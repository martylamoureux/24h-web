<?php namespace App\Http\Controllers;

use App\Client;
use App\Company;
use App\User;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class ClientsController extends Controller {

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
        $router->pattern('client_id', '[0-9]+');

        $router->get('/', ['uses' => 'ClientsController@index',
            'as' => 'clients.index']);

        $router->get('/nouveau', ['uses' => 'ClientsController@add',
            'as' => 'clients.add']);

        $router->post('/nouveau', 'ClientsController@create');

        $router->get('/{client_id}/modifier', ['uses' => 'ClientsController@edit',
            'as' => 'clients.edit']);

        $router->post('/{client_id}/modifier', 'ClientsController@update');

        $router->get('/{client_id}/supprimer', ['uses' => 'ClientsController@delete',
            'as' => 'clients.delete']);

        $router->get('/{client_id}', ['uses' => 'ClientsController@detail',
            'as' => 'clients.detail']);
    }

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients = Client::paginate(15);
        return view('clients.index', compact('clients'));
	}

    public function add()
    {
        $client = new Client();
        return view('clients.form', compact('client'));
    }

    public function create(Request $req)
    {
        $this->validate($req, [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $client = new Client($req->all());

        $user = new User();
        $user->name = $client->name;
        $user->email = $req->get('email');
        $user->password = $req->get('password');
        $user->type = 'CL';
        $user->save();
        $client->user_id = $user->id;
        $client->save();

        $req->session()->flash('success', "Le client $client a bien été créé.");

        return redirect()->route('clients.index');
    }

    public function edit($client_id)
    {
        $client = Client::findOrFail($client_id);
        return view('clients.form', compact('client'));
    }

    public function update($client_id, Request $req)
    {
        $client = Client::findOrFail($client_id);
        $this->validate($req, [
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'email' => 'required|email|unique:users,id,'.$client_id,
        ]);

        $client->fill($req->all());

        $client->user->name = $client->name;
        $client->user->email = $req->get('email');
        $client->user->save();
        $client->save();

        $req->session()->flash('success', "Le client $client a bien été modifié.");

        return redirect()->route('clients.index');
    }

    public function delete($client_id, Request $req)
    {
        $client = Client::findOrFail($client_id);
        $client->user->delete();
        $client->delete();
        $req->session()->flash('success', "Le client $client a bien été supprimé.");
        return redirect()->route('clients.index');
    }

    public function detail($client_id, Request $req, Guard $auth)
    {
        if ($auth->user()->type == 'CO' || ($auth->user()->type == 'CL' && $client_id != $auth->user()->client->id))
            abort(403, "Non autorisé");

        $client = Client::findOrFail($client_id);

        return view('clients.detail', compact('client'));
    }



}
