<?php

namespace App\Http\Controllers;

use App\Catalog;
use App\Catalog_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{

    public function ProdactionIndex()
    {
        $catalogs = Catalog::all();
        $catalog_groups = Catalog_group::all();

        return view('catalog.index',compact('catalogs', 'catalog_groups'));
    }


    public function index()
    {
        $groups = Catalog_group::all();
        $catalogs = DB::table('catalogs')->orderBy('position','asc')->get();
        return view('admin.catalog',compact('groups','catalogs'));
    }


    public function getGroup()
    {
        foreach (Catalog_group::all() as $key => $value) {
            echo '<a href="javascript:void(0);" id="'.$value->id.'" class="list-group-item list-group-item-action">'.$value->name.'</a>';
        }  
    }


    public function edit($id)
    {
        $artist = Catalog::find($id);

        if (!isset($artist)){
            return "Артист не найден";
        }

        return view('admin.edit', compact('artist'));
    }



    public function addArtist(Request $request)
    {
        $data = $request->all();
        if ($data['group'] == 1) {
                $path = $data['photo']->store('public/avatars');
                    Catalog_group::create([
                        'name' => $data['name'],
                        'description' => $data['description'],
                        'photo' => $path,
                    ]);
                    return redirect('admin');
        }else{
                $path = $data['photo']->store('public/avatars');
                    Catalog::create([
                        'catalog_groups_id' => $data['catalog_groups_id'],
                        'name' => $data['name'],
                        'price_from' => $data['price_from'],
                        'price_up_to' => $data['price_up_to'],
                        'description' => $data['description'],
                        'youtube' => $data['youtube'],
                        'photo' => $path,
                        'tel' => $data['tel'],
                        'tel_work' => $data['tel_work'],
                        'position' => $data['position'],
                    ]);
                        return redirect('admin'); 
        }

    }


    public function store(Request $request)
    {
        if ($request['type'] == "prodaction") {
           foreach (Catalog::where('catalog_groups_id', '=', $request['id'])->orderBy('position','asc')->get() as $key => $value) {
        echo '<li class="product-wrapper">
                  <a href="" class="product">
                      <div class="product-photo">
                      <img src="images/roses/1.jpg" alt="">
                      </div>
                      <h4>'.$value->name.'</h4>
                      <p>'.$value->description.'</p>
                  </a>
              </li>';
           }
        }else{

            foreach (Catalog::where('catalog_groups_id', '=', $request['id'])->orderBy('position','asc')->get() as $key => $value) {
                echo '<div class="col-md-4 mb-4">
                  <div class="card">
                    <svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Image cap"><title>Placeholder</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="50%" y="50%">Изображение</text></svg>
                    <div class="card-body">
                      <h5 class="card-title">'.$value->name.'</h5>
                      <p class="card-text">'.$value->description.'</p>
                    </div>
                    <div class="card-footer">
                      <!-- <small class="text-muted">Активно</small> -->
                        <a href="admin/artist/'.$value->id.'/edit" class="card-link">Посмотреть</a>
                    </div>
                  </div>
                </div>';
            }
        }
    }


    public function editid(Request $request)
    {
        $data = $request->all();
        $path = $data['photo']->store('public/avatars');
        $artist = Catalog::find($data['id']);
        $artist->name = $data['name'];
        $artist->price_from = $data['price_from'];
        $artist->price_up_to = $data['price_up_to'];
        $artist->tel = $data['tel'];
        $artist->position = $data['position'];
        $artist->photo = $path;
        $artist->save();

        return redirect('admin');

            
    }


    public function deleteid(Request $request)
    {
        $data = $request->all();

        $model = Catalog::find($data['id']);

        if ($model) {
            $model->delete();
                return "Артист удален";
        }else{
                return "Артист не найден";
        }
    }

}
