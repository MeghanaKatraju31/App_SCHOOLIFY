<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Tokenization\WhitespaceTokenizer;
use OpenAI\OpenAI;

class BotController extends Controller
{
    protected $conversationHistory = [];
    protected $classifier;
    protected $tfIdfTransformer;
    protected $openAI;

    public function __construct()
    {
        // Initialize the support vector machine classifier
        $this->classifier = new SVC(Kernel::LINEAR, $cost = 1000);

        // Initialize TfIdfTransformer for feature extraction
        $this->tfIdfTransformer = new TfIdfTransformer();

        // Train the classifier with some example data (intent classification)
        $this->trainClassifier();

        $this->openAI = new OpenAI('YOUR_OPENAI_API_KEY');
    }

    public function getReply(Request $request)
    {
        $inputMessage = $request->message;
        $intent = $this->classifyIntent($inputMessage);

        if ($intent === 'greeting') {
            return 'Hello! How can I assist you today?';
        } elseif ($intent === 'question') {
            return $this->processInput($inputMessage);
        } else {
            return "I'm sorry, I didn't understand. Can you please provide more details?";
        }
    }

    protected function processInput($inputMessage)
    {
       
        $this->conversationHistory[] = $inputMessage;

        
        $prompt = implode("\n", $this->conversationHistory);
        $gptResponse = $this->generateGptResponse($prompt);
        $response = $gptResponse['choices'][0]['text'];

 
        $threshold = 70;
        foreach ($this->getQaData() as $qa) {
            similar_text($inputMessage, $qa['question'], $similarityPercentage);
            if ($similarityPercentage >= $threshold) {
                $response .= "\n" . $qa['answer'];
            }
        }

        $this->conversationHistory[] = $response;

        return $response;
    }

    protected function generateGptResponse($prompt)
    {
        $result = $this->openAI->createCompletion([
            'engine' => 'text-davinci-003',
            'prompt' => $prompt,
            'max_tokens' => 100,
        ]);

        return $result->getDecodedBody();
    }

    protected function classifyIntent($inputMessage)
    {
      
        $samples = ['Hello', 'Hi', 'Hey', 'How can I access my panel?', 'Where can I get the results?'];
        $labels = ['greeting', 'greeting', 'greeting', 'question', 'question'];

        $samples = array_map('strtolower', $samples);
        $inputMessage = strtolower($inputMessage);

      
        $this->tfIdfTransformer->fit($samples);
        $samples = $this->tfIdfTransformer->transform($samples);
        $inputMessage = $this->tfIdfTransformer->transform([$inputMessage]);

        $this->classifier->train($samples, $labels);

        return $this->classifier->predict($inputMessage);
    }

    protected function trainClassifier()
    {
      n
        $samples = ['Hello', 'Hi', 'Hey', 'How can I access my panel?', 'Where can I get the results?'];
        $labels = ['greeting', 'greeting', 'greeting', 'question', 'question'];

        $samples = array_map('strtolower', $samples);

        // Tokenization and feature extraction
        $this->tfIdfTransformer->fit($samples);
        $samples = $this->tfIdfTransformer->transform($samples);

        // Train the classifier
        $this->classifier->train($samples, $labels);
    }

    protected function getQaData()
    {
        return [
            // Add your predefined Q&A pairs here
            // Example:
            [
                'question' => 'What type of services do you provide?',
                'answer' => 'Our website provides access to various services including course registration, grades, class schedules, academic resources, and more. How can I assist you further?',
            ],
            // Add more Q&A pairs as needed
        ];
    }
}
