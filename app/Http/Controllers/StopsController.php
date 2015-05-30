<?php namespace App\Http\Controllers;

use App\Company;
use App\Stop;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StopsController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('agent', ['except' => [

        ]]);
	}

    public static function routes($router)
    {
        $router->pattern('stop_id', '[0-9]+');

        $router->get('/nouveau', ['uses' => 'StopsController@add',
            'as' => 'stops.add']);

        $router->post('/nouveau', 'StopsController@create');

        $router->get('/{stop_id}/modifier', ['uses' => 'StopsController@edit',
            'as' => 'stops.edit']);

        $router->post('/{stop_id}/modifier', 'StopsController@update');

        $router->get('/{stop_id}/supprimer', ['uses' => 'StopsController@delete',
            'as' => 'stops.delete']);
    }

    public function add(Request $req, $company_id, $ship_id)
    {
        $stop = new Stop(['date_in'=>date('d/m/Y')]);
        return view('stops.form', compact('stop', 'company_id', 'ship_id'));
    }

    public function create(Request $req, $company_id, $ship_id)
    {
        $this->validate($req, [
            'date_in' => 'required|date_format:d/m/Y',
            'date_out' => 'date_format:d/m/Y',
        ]);
        $stop = new Stop($req->all());
        $stop->ship_id = $ship_id;
        $stop->save();

        $req->session()->flash('success', "L'escale $stop a bien été créée.");

        return redirect()->route('ships.detail', [$company_id, $ship_id]);
    }

    public function edit($company_id, $ship_id, $stop_id)
    {
        $stop = Stop::findOrFail($stop_id);
        return view('stops.form', compact('stop', 'company_id', 'ship_id'));
    }

    public function update($company_id, $ship_id, $stop_id, Request $req)
    {
        $stop = Stop::findOrFail($stop_id);
        $this->validate($req, [
            'date_in' => 'required|date_format:d/m/Y',
            'date_out' => 'date_format:d/m/Y',
        ]);

        $stop->fill($req->all());
        $stop->save();

        $req->session()->flash('success', "L'escale $stop a bien été modifiée");

        return redirect()->route('ships.detail', [$company_id, $ship_id]);
    }

    public function delete($company_id, $ship_id, $stop_id, Request $req)
    {
        $stop = Stop::findOrFail($stop_id);
        $stop->delete();

        $req->session()->flash('success', "L'escale $stop a bien été supprimée.");
        return redirect()->route('ships.detail', [$company_id, $ship_id]);
    }

    public function detail($stop_id, Request $req)
    {
        $stop = Stop::findOrFail($stop_id);

        return view('ships.detail', compact('stop'));
    }

}
