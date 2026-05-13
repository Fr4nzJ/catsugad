<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AnthropicService
{
    private ?string $apiKey;
    private string $model = 'claude-haiku-4-5-20251001';
    private string $baseUrl = 'https://api.anthropic.com/v1/messages';

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key') ?? null;
    }

    /**
     * Suggest a member for a vacant position using Claude
     */
    public function suggestMemberForPosition(string $position, string $role, string $section): string
    {
        if (is_null($this->apiKey) || empty($this->apiKey)) {
            return 'No API key configured. Please set ANTHROPIC_API_KEY in your .env file.';
        }

        try {
            $response = Http::withHeaders([
                'x-api-key' => (string) $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => $this->model,
                'max_tokens' => 256,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "You are an assistant for a Philippine State University's GAD Focal Point System. "
                            . "The position '{$position}' ({$role}) in the section '{$section}' is currently vacant. "
                            . "Generate a short, professional note (2-3 sentences) describing what qualifications "
                            . "or type of person should fill this role, based on the position title. "
                            . "Reply in plain text only, no markdown."
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json('content.0.text', 'No suggestion available.');
            }

            Log::warning('Anthropic API error: ' . $response->status());
            return 'Unable to generate suggestion at this time.';
        } catch (\Exception $e) {
            Log::error('Anthropic service error: ' . $e->getMessage());
            return 'Error generating suggestion: ' . $e->getMessage();
        }
    }

    /**
     * Generate an organizational chart summary
     */
    public function generateOrgChartSummary(array $members): string
    {
        if (is_null($this->apiKey) || empty($this->apiKey)) {
            return '';
        }

        try {
            $vacantCount = collect($members)->where('is_vacant', true)->count();
            $totalCount = count($members);

            $response = Http::withHeaders([
                'x-api-key' => (string) $this->apiKey,
                'anthropic-version' => '2023-06-01',
                'content-type' => 'application/json',
            ])->post($this->baseUrl, [
                'model' => $this->model,
                'max_tokens' => 200,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "Generate a 2-sentence professional summary for a GAD Focal Point System "
                            . "organizational chart. Total positions: {$totalCount}. Vacant: {$vacantCount}. "
                            . "Mention the system's purpose in gender mainstreaming in a Philippine State University context. "
                            . "Plain text only."
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json('content.0.text', '');
            }

            Log::warning('Anthropic API error for summary: ' . $response->status());
            return '';
        } catch (\Exception $e) {
            Log::error('Anthropic service summary error: ' . $e->getMessage());
            return '';
        }
    }
}
