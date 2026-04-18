<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quizzes = Quiz::with('lesson')->latest()->paginate(10);
        return view('quizzes.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::orderBy('id')->get();
        return view('quizzes.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id|unique:quizzes,lesson_id',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string|min:5',
            'questions.*.options' => 'required|array|min:4',
            'questions.*.options.*' => 'required|string|min:1',
            'questions.*.correct' => 'required|integer',
        ]);

        $quiz = Quiz::create([
            'lesson_id' => $request->lesson_id,
        ]);

        foreach ($request->questions as $q) {
            $question = QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
            ]);

            foreach ($q['options'] as $index => $option) {
                QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                    'is_correct' => $index == $q['correct'],
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz)
                        ->with('success', 'Quiz berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load('lesson', 'questions.options');
        return view('quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::orderBy('id')->get();
        $quiz->load('questions.options');
        return view('quizzes.edit', compact('quiz', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id|unique:quizzes,lesson_id,' . $quiz->id,
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string|min:5',
            'questions.*.options' => 'required|array|min:4',
            'questions.*.options.*' => 'required|string|min:1',
            'questions.*.correct' => 'required|integer',
        ]);

        $quiz->update(['lesson_id' => $request->lesson_id]);

        // Delete existing questions and options
        $quiz->questions()->delete();

        // Create new questions and options
        foreach ($request->questions as $q) {
            $question = QuizQuestion::create([
                'quiz_id' => $quiz->id,
                'question' => $q['question'],
            ]);

            foreach ($q['options'] as $index => $option) {
                QuizOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                    'is_correct' => $index == $q['correct'],
                ]);
            }
        }

        return redirect()->route('quizzes.show', $quiz)
                        ->with('success', 'Quiz berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('quizzes.index')
                        ->with('success', 'Quiz berhasil dihapus.');
    }
}
