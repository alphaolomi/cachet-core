<?php

namespace Cachet\Http\Controllers\StatusPage;

use Cachet\Cachet;
use Cachet\Models\ComponentGroup;
use Cachet\Models\Incident;
use Illuminate\View\View;

class StatusPageController
{
    /**
     * Show the status page.
     */
    public function index(): View
    {
        return view('cachet::status-page.index', [
            'componentGroups' => ComponentGroup::with(['components' => fn ($query) => $query->orderBy('order')])
                ->when(auth()->check(), fn ($query) => $query->users(), fn ($query) => $query->guests())
                ->whereHas('components')
                ->get(),

            'cachetVersion' => Cachet::version(),
        ]);
    }

    /**
     * Show the details of a particular incident.
     */
    public function show(Incident $incident): View
    {
        return view('cachet::status-page.incident', [
            'incident' => $incident,
        ]);
    }
}
