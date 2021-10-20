<?php

namespace App\Http\Controllers;

use App\Events\ScheduleUpdateEvent;
use App\Http\Requests\ScheduleCreateRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Models\Job;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request) {
        $schedules = Schedule::where(function($q) use ($request) {
            if ($request->get('start_date')) {
                $q->whereDate('date', '>=', Carbon::create($request->get('start_date')));
            }
            if ($request->get('end_date')) {
                $q->whereDate('date', '<=', Carbon::create($request->get('end_date')));
            }

            if (!auth()->check()) {
                $q->where('status', 'accepted');
            }
        })->with(['job', 'user'])->get();
        return new ScheduleCollection($schedules);
    }

    public function create(ScheduleCreateRequest $request) {

        $schedule = Schedule::create([
            'date' => Carbon::create($request->get('date')),
            'job_id' => Job::where('name', $request->get('job'))->firstOrFail()->id,
            'shift' => $request->get('shift'),
            'description' => $request->get('description'),
            'user_id' => auth()->user()->id
        ]);

        return response(['message' => 'success', 'data' => new ScheduleResource($schedule)], 201);
    }

    public function update(Schedule $schedule, ScheduleUpdateRequest $request) {
        $schedule->status = $request->get('status');
        if ($request->get('description')) {
            $schedule->description = $request->get('description');
        }
        $schedule->save();
        event(new ScheduleUpdateEvent($schedule));

        return response(['message' => 'success'], 200);
    }
}
