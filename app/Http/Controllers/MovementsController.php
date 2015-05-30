<?php namespace App\Http\Controllers;

use App\Company;
use App\Movement;
use App\User;
use Carbon\Carbon;
use App\Container;
use Illuminate\Http\Request;

class MovementsController extends Controller {

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
        $router->pattern('movement_id', '[0-9]+');

        $router->get('/nouveau', ['uses' => 'MovementsController@add',
            'as' => 'movements.add']);

        $router->post('/nouveau', 'MovementsController@create');

        $router->get('/{movement_id}/modifier', ['uses' => 'MovementsController@edit',
            'as' => 'movements.edit']);

        $router->post('/{movement_id}/modifier', 'MovementsController@update');

        $router->get('/{movement_id}/supprimer', ['uses' => 'MovementsController@delete',
            'as' => 'movements.delete']);
    }

    public function add(Request $req, $client_id, $container_id)
    {
        $movement = new Movement();
        $ship_id = Container::find($container_id)->ship_id;
        return view('movements.form', compact('movement', 'client_id', 'container_id', 'ship_id'));
    }

    public function create(Request $req, $client_id, $container_id)
    {
        $this->validate($req, [
            'type' => 'required|in:C,D'
        ]);
        $movement = new Movement($req->all());
        $movement->container_id = $container_id;
        $movement->save();

        $req->session()->flash('success', "Le mouvement $movement a bien été créé.");

        return redirect()->route('containers.detail', [$client_id, $container_id]);
    }

    public function edit($client_id, $container_id, $movement_id)
    {
        $movement = Movement::findOrFail($movement_id);
        $ship_id = Container::find($container_id)->ship_id;
        return view('movements.form', compact('movement', 'client_id', 'container_id', 'ship_id'));
    }

    public function update($client_id, $container_id, $movement_id, Request $req)
    {
        $movement = Movement::findOrFail($movement_id);
        $this->validate($req, [
            'type' => 'required|in:C,D'
        ]);

        $movement->fill($req->all());
        $movement->save();

        $req->session()->flash('success', "L'escale $movement a bien été modifié");

        return redirect()->route('containers.detail', [$client_id, $container_id]);
    }

    public function delete($client_id, $container_id, $movement_id, Request $req)
    {
        $movement = Movement::findOrFail($movement_id);
        $movement->delete();

        $req->session()->flash('success', "L'escale $movement a bien été supprimé.");
        return redirect()->route('containers.detail', [$client_id, $container_id]);
    }

    public function detail($movement_id, Request $req)
    {
        $movement = Movement::findOrFail($movement_id);

        return view('movements.detail', compact('movement'));
    }

}
