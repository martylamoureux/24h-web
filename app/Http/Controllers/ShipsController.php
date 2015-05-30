<?php namespace App\Http\Controllers;

use App\Company;
use App\Ship;
use App\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class ShipsController extends Controller {

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
            'detail'
        ]]);
	}

    public static function routes($router)
    {
        $router->pattern('ship_id', '[0-9]+');

        $router->get('/nouveau', ['uses' => 'ShipsController@add',
            'as' => 'ships.add']);

        $router->post('/nouveau', 'ShipsController@create');

        $router->get('/{ship_id}/modifier', ['uses' => 'ShipsController@edit',
            'as' => 'ships.edit']);

        $router->post('/{ship_id}/modifier', 'ShipsController@update');

        $router->get('/{ship_id}/supprimer', ['uses' => 'ShipsController@delete',
            'as' => 'ships.delete']);

        $router->get('/{ship_id}', ['uses' => 'ShipsController@detail',
            'as' => 'ships.detail']);
    }

    public function add(Request $req, $company_id)
    {
        $ship = new Ship();
        return view('ships.form', compact('ship', 'company_id'));
    }

    public function create(Request $req, $company_id)
    {
        $this->validate($req, [
            'name' => 'required',
            'capacity' => 'required|numeric',
        ]);

        $ship = new Ship($req->all());
        $ship->company_id = $company_id;
        $ship->save();

        $req->session()->flash('success', "Le navire $ship a bien été créé.");

        return redirect()->route('companies.detail', $company_id);
    }

    public function edit($company_id, $ship_id)
    {
        $ship = Ship::findOrFail($ship_id);
        return view('ships.form', compact('ship', 'company_id'));
    }

    public function update($company_id, $ship_id, Request $req)
    {
        $ship = Ship::findOrFail($ship_id);
        $this->validate($req, [
            'name' => 'required',
            'capacity' => 'required|numeric',
        ]);

        $ship->fill($req->all());
        $ship->save();

        $req->session()->flash('success', "Le navire $ship a bien été modifié.");

        return redirect()->route('companies.detail', $company_id);
    }

    public function delete($company_id, $ship_id, Request $req)
    {
        $ship = Ship::findOrFail($ship_id);
        $ship->delete();

        $req->session()->flash('success', "Le navire $ship a bien été supprimé.");
        return redirect()->route('companies.detail', $company_id);
    }

    public function detail($company_id, $ship_id, Request $req, Guard $auth)
    {
        if ($auth->user()->type == 'CL' || ($auth->user()->type == 'CO' && $company_id != $auth->user()->company->id))
            abort(403, "Non autorisé");

        $ship = Ship::findOrFail($ship_id);

        return view('ships.detail', compact('ship', 'company_id'));
    }

}
