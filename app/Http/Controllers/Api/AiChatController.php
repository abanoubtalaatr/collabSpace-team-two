<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AiChatController extends Controller
{
    public function ask(Request $request)
    {
        // 1. التفتيش والأمان
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->message;

        // 2. كتالوج الجداول (الـ Schema)
        $schemaContext = "You are an expert SQL generator. Your job is to translate the user's question into a valid MySQL query based ONLY on these tables:
        - Table `projects` (id, name, description)
        - Table `tasks` (id, title, status, priority, project_id, user_id)
        Return ONLY a JSON object: {\"sql\": \"SELECT ...\"}. Do not wrap the response in markdown code blocks.";

        // 3. نداء الـ AI الأول (طلب الـ SQL من Groq المجاني)
        $response = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $schemaContext],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'temperature' => 0
            ]);

        $aiData = $response->json();
        
        if (!isset($aiData['choices'][0]['message']['content'])) {
            return response()->json([
                'success' => false,
                'error' => 'فيه مشكلة في الخطوة الأولى مع Groq',
                'raw_response' => $aiData
            ], 500);
        }

        // فك الـ SQL وتشغيله في الداتا بيز
        $sqlData = json_decode($aiData['choices'][0]['message']['content'], true);
        $sqlQuery = $sqlData['sql'];
        
        // جلب البيانات الخام من الداتا بيز
        $dbResult = DB::select($sqlQuery);

        // 4. نداء الـ AI الثاني (صياغة رد فصيح ومبسط وممتاز من Groq)
        $finalResponse = Http::withToken(env('OPENAI_API_KEY'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => 'أنت مساعد ذكي ومحترف في نظام collabSpace. خذ البيانات الخام المرفقة وأجب على سؤال المستخدم بلغة عربية فصحى بسيطة، واضحة، ومباشرة. ابدأ بالإجابة فوراً دون مقدمات، واعرض الأرقام والتفاصيل بشكل منسق ومريح للقراءة.'],
                    ['role' => 'user', 'content' => "سؤال المستخدم الأصلي: " . $userMessage . " | البيانات الحقيقية من الداتا بيز: " . json_encode($dbResult)]
                ],
                'temperature' => 0.2
            ]);

        $finalData = $finalResponse->json();
        
        // استخلاص الجواب النهائي المنسق
        $aiFinalAnswer = $finalData['choices'][0]['message']['content'] ?? 'مقدرتش أحلل البيانات حالياً.';

        // الرد النهائي النظيف للـ Frontend
        return response()->json([
            'success' => true,
            'answer' => $aiFinalAnswer
        ]);
    }
}