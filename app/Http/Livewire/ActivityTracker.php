<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;

class ActivityTracker extends Component
{
    use WithPagination;

    public $search = '';

    public $name;

    public $date;

    public $status;

    public $comments;

    public $editMode = false;

    public $activityId;

    public $showDelete = [];

    public $completionPercentage = 0;

    // public $summaryPeriod;

    public $activity; // Holds activities for the summary

    public $start_date;
    public $end_date;

    //event listeners
    public $listeners = [
        'deleteConfirmed' => 'deleteActivity',
        'activityUpdated' => 'updateCompletionPercentage',
    ];

    protected $rules = [
        'name' => 'required|string',
        'date' => 'required|date',
        'status' => 'required|in:completed,pending,in_progress',
        'comments' => 'nullable|string',
    ];

    public function toggleDeleteIcon($id)
    {
        if (in_array($id, $this->showDelete)) {
            $this->showDelete = array_diff($this->showDelete, [$id]);
        } else {
            $this->showDelete[] = $id;
        }
    }

    public function createActivity()
    {
        $this->validate();

        Activity::create([
            'name' => $this->name,
            'date' => $this->date,
            'status' => $this->status,
            'comments' => $this->comments,
        ]);

        $this->resetForm();
        $this->updateCompletionPercentage(); // Update percentage and emit event
        $this->emit('activitySaved');
        session()->flash('message', 'Activity created successfully.');
    }

    private function resetForm()
    {
        $this->name = '';
        $this->date = '';
        $this->status = '';
        $this->comments = '';
        $this->editMode = false;
    }

    public function render()
    {
        return view('livewire.activity-tracker', [
            'activities' => Activity::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('status', 'like', '%'.$this->search.'%')
                ->orderBy('date', 'desc')
                ->paginate(10),
        ]);
    }

    public function viewActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $this->activityId = $activity->id;
        $this->name = $activity->name;
        $this->date = $activity->date;
        $this->status = $activity->status;
        $this->comments = $activity->comments;
    }

    public function editActivity($id)
    {
        $activity = Activity::findOrFail($id);
        $this->activityId = $activity->id;
        $this->name = $activity->name;
        $this->date = $activity->date;
        $this->status = $activity->status;
        $this->comments = $activity->comments;
        $this->editMode = true;
    }

    public function updateActivity()
    {
        $this->validate();

        $activity = Activity::find($this->activityId);
        $activity->update([
            'name' => $this->name,
            'date' => $this->date,
            'status' => $this->status,
            'comments' => $this->comments,
        ]);

        $this->resetForm();
        $this->updateCompletionPercentage();
        $this->emit('activitySaved');
        session()->flash('message', 'Activity updated successfully.');
    }

    public function deleteActivity($id)
    {
        $activity = Activity::find($id);
        if ($activity) {
            $activity->delete();
            $this->updateCompletionPercentage();
            session()->flash('message', 'Activity deleted successfully.');
        }
    }

    public function mount()
{
    if (!Auth::check()) {
        abort(403, 'Unauthorized action.');
    }

    $this->updateCompletionPercentage(); // Recalculate progress on component initialization
}

private function calculateProgress(): array
{
    $totals = Activity::selectRaw('
        COUNT(*) as total,
        SUM(status = "completed") as completed,
        SUM(status = "in_progress") as in_progress
    ')->first();

    return [
        'total' => $totals->total,
        'completed' => $totals->completed,
        'in_progress' => $totals->in_progress,
    ];
}

public function updateCompletionPercentage()
{
    $progress = $this->calculateProgress();
    $this->completionPercentage = $progress['total'] > 0
        ? (($progress['completed'] * 1) + ($progress['in_progress'] * 0.5)) / $progress['total'] * 100
        : 0;

    $this->emit('progressUpdated', $this->completionPercentage);
    logger('Progress Updated: ' . $this->completionPercentage . '%');
}





}
