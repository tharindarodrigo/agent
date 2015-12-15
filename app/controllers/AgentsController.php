<?php

class AgentsController extends \BaseController
{

    /**
     * Display a listing of agents
     *
     * @return Response
     */
    public function index()
    {
        $agents = Agent::all();

        return View::make('control-panel.agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new agent
     *
     * @return Response
     */
    public function create()
    {
        return View::make('control-panel.agents.create');
    }

    /**
     * Store a newly created agent in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make($data = Input::all(), Agent::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        Agent::create($data);

        return Redirect::route('control-panel.agents.index');
    }

    /**
     * Display the specified agent.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $agent = Agent::findOrFail($id);

        return View::make('control-panel.agents.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified agent.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $agent = Agent::find($id);

        return View::make('control-panel.agents.edit', compact('agent'));
    }

    /**
     * Update the specified agent in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        dd('asdasd');

        $agent = Agent::findOrFail($id);

        $validator = Validator::make($data = Input::all(), Agent::$rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $agent->update($data);

        return Redirect::route('control-panel.1agents.index');
    }

    /**
     * Remove the specified agent from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Agent::destroy($id);

        return Redirect::route('agents.index');
    }


    public function changeMarket()
    {

    }
}
