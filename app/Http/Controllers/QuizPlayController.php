<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizPlayController extends Controller
{
    /**
     * Show quiz start page
     */
    public function start($lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        $quiz = $lesson->quiz;

        if (!$quiz) {
            return redirect()->route('lessons.show', $lesson_id)
                            ->with('error', 'Quiz tidak ditemukan untuk lesson ini.');
        }

        $totalQuestions = $quiz->questions->count();

        return view('quiz_play.start', compact('lesson', 'quiz', 'totalQuestions'));
    }

    /**
     * Play quiz - show questions one by one
     */
    public function play($quiz_id)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quiz_id);
        
        // Get current question index from session
        $currentIndex = session()->get('current_question_' . $quiz_id, 0);
        $answers = session()->get('answers_' . $quiz_id, []);

        if ($currentIndex >= $quiz->questions->count()) {
            return redirect()->route('quiz.result', $quiz_id);
        }

        $currentQuestion = $quiz->questions[$currentIndex];
        $totalQuestions = $quiz->questions->count();
        $currentNumber = $currentIndex + 1;

        return view('quiz_play.play', compact(
            'quiz',
            'currentQuestion',
            'currentIndex',
            'totalQuestions',
            'currentNumber',
            'answers'
        ));
    }

    /**
     * Submit answer
     */
    public function submitAnswer(Request $request, $quiz_id)
    {
        $request->validate([
            'answer' => 'required|integer',
            'current_index' => 'required|integer',
        ]);

        $quiz = Quiz::findOrFail($quiz_id);
        $currentIndex = $request->current_index;
        $currentQuestion = $quiz->questions[$currentIndex];
        $selectedOptionId = $request->answer;

        // Get or initialize session data
        $answers = session()->get('answers_' . $quiz_id, []);

        // Check if answer is correct
        $selectedOption = $currentQuestion->options->find($selectedOptionId);
        $isCorrect = $selectedOption && $selectedOption->is_correct;

        // Store answer
        $answers[$currentIndex] = [
            'question_id' => $currentQuestion->id,
            'option_id' => $selectedOptionId,
            'is_correct' => $isCorrect,
        ];

        session()->put('answers_' . $quiz_id, $answers);
        session()->put('current_question_' . $quiz_id, $currentIndex + 1);

        // If all questions answered, redirect to result
        if ($currentIndex + 1 >= $quiz->questions->count()) {
            return redirect()->route('quiz.result', $quiz_id);
        }

        return redirect()->route('quiz.play', $quiz_id);
    }

    /**
     * Show quiz result
     */
    public function result($quiz_id)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($quiz_id);
        $answers = session()->get('answers_' . $quiz_id, []);

        if (empty($answers)) {
            return redirect()->route('quiz.start', $quiz->lesson_id);
        }

        // Calculate score
        $score = 0;
        foreach ($answers as $answer) {
            if ($answer['is_correct']) {
                $score++;
            }
        }

        $totalQuestions = $quiz->questions->count();
        $percentage = round(($score / $totalQuestions) * 100);
        $isPassed = $percentage >= 70; // 70% minimum passing grade

        // Save attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz_id,
            'answers' => json_encode($answers),
            'score' => $score,
            'total_questions' => $totalQuestions,
        ]);

        // Clear session
        session()->forget('answers_' . $quiz_id);
        session()->forget('current_question_' . $quiz_id);

        return view('quiz_play.result', compact(
            'quiz',
            'score',
            'totalQuestions',
            'percentage',
            'isPassed',
            'answers'
        ));
    }

    /**
     * Reset quiz
     */
    public function reset($quiz_id)
    {
        $quiz = Quiz::findOrFail($quiz_id);

        session()->forget('answers_' . $quiz_id);
        session()->forget('current_question_' . $quiz_id);

        return redirect()->route('quiz.start', $quiz->lesson_id);
    }
}
