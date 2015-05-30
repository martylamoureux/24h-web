<?php namespace App\Http\Controllers;

use App\Container;
use App\Ship;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;

class ContainersController extends Controller
{

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
        $router->pattern('container_id', '[0-9]+');

        $router->get('/nouveau', ['uses' => 'ContainersController@add',
            'as' => 'containers.add']);

        $router->post('/nouveau', 'ContainersController@create');

        $router->get('/{container_id}/modifier', ['uses' => 'ContainersController@edit',
            'as' => 'containers.edit']);

        $router->post('/{container_id}/modifier', 'ContainersController@update');

        $router->get('/{container_id}/supprimer', ['uses' => 'ContainersController@delete',
            'as' => 'containers.delete']);

        $router->get('/{container_id}', ['uses' => 'ContainersController@detail',
            'as' => 'containers.detail']);
    }

    public function add(Request $req, $client_id)
    {
        $container = new Container();
        return view('containers.form', compact('container', 'client_id'));
    }

    public function create(Request $req, $client_id)
    {
        $this->validate($req, [
            'capacity' => 'required|in:1,2',
            'ship_id' => 'required',
        ]);


        $ship = Ship::find($req->get('ship_id'))->first();

        $totalCapacity = $req->get('capacity');

        foreach ($ship->containers as $container) {
            $totalCapacity += $container->capacity;
        }

        if ($totalCapacity > $ship->capacity) {
            $req->session()->flash('error', "Le conteneur ne peut être ajouté, le navire a dépassé sa capacité maximale.");

            return redirect()->back()->withInput();
        }

        $container = new Container($req->all());
        $container->client_id = $client_id;
        $container->save();

        $req->session()->flash('success', "Le conteneur $container a bien été créé.");

        return redirect()->route('clients.detail', $client_id);


        }

        public
        function edit($client_id, $container_id)
        {
            $container = Container::findOrFail($container_id);
            return view('containers.form', compact('container', 'client_id'));
        }

        public
        function update($client_id, $container_id, Request $req)
        {
            $container = Container::findOrFail($container_id);
            $this->validate($req, [
                'capacity' => 'required|in:1,2',
                'ship_id' => 'required',
            ]);


            $ship = Ship::find($req->get('ship_id'))->first();
            $totalCapacity = 0;

            foreach ($ship->containers as $container) {
                if ($container->id == $container_id)
                    $container->capacity = $req->get('capacity');

                $totalCapacity += $container->capacity;
            }

            if ($totalCapacity > $ship->capacity) {
                $req->session()->flash('error', "Le conteneur ne peut être ajouté, le navire a dépassé sa capacité maximale.");

                return redirect()->back()->withInput();
            }


            $container->fill($req->all());
            $container->save();

            $req->session()->flash('success', "Le conteneur $container a bien été modifié.");

            return redirect()->route('clients.detail', $client_id);
        }

        public
        function delete($client_id, $container_id, Request $req)
        {
            $container = Container::findOrFail($container_id);
            $container->delete();

            $req->session()->flash('success', "Le conteneur $container a bien été supprimé.");
            return redirect()->route('clients.detail', $client_id);
        }

        public
        function detail($client_id, $container_id, Request $req, Guard $auth)
        {
            if ($auth->user()->type == 'CO' || ($auth->user()->type == 'CL' && $client_id != $auth->user()->client->id))
                abort(403, "Non autorisé");

            $container = Container::findOrFail($container_id);
            return view('containers.detail', compact('container', 'client_id'));
        }

    }