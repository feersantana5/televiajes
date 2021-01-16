<?php

namespace App\Http\Controllers;

use App\Actividades;
use App\Cruceros;
use App\Escolares;
use App\Paquetes;
use App\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function crearProducto()
    {
        return view('/crearProducto');
    }

    public function shopAdmin(){

        return view('/shopAdmin');
    }

    public function numero_productos() {
        $getnumProduct = count(Products::all());
        return $getnumProduct;
    }
    public function get_numTransc() {

        return  'Transacciones';
    }

    public function listaProductos()
    {
        $products = Products::get();
        $paquetes = Paquetes::get();
        $cruises = Cruceros::get();
        $activities = Actividades::get();
        $escolares = Escolares::get();


        return view('/shopAdmin')
            ->with('products', $products)
            ->with('paquetes', $paquetes)
            ->with('cruises', $cruises)
            ->with('activities', $activities)
            ->with('escolares', $escolares);

    }

    public function listaPaquetes()
    {
        $products = Products::get();
        $paquetes = Paquetes::get();

        return view('/paquetes')
            ->with('products', $products)
            ->with('paquetes', $paquetes);
    }
    public function listaCruceros()
    {
        $products = Products::get();
        $cruises = Cruceros::get();

        return view('/cruceros')
            ->with('products', $products)
            ->with('cruises', $cruises);
    }

    public function listaActividades()
    {
        $products = Products::get();
        $activities = Actividades::get();

        return view('/actividades')
            ->with('products', $products)
            ->with('activities', $activities);
    }
    public function listaEscolares()
    {
        $products = Products::get();
        $escolares = Escolares::get();

        return view('/escolares')
            ->with('products', $products)
            ->with('escolares', $escolares);
    }


    public function addProducto(){
        if (isset($_POST["type"], $_POST["name"], $_POST["description"], $_POST["subtype"], $_POST["price"], $_POST["stock"],$_POST["date"])) {

            $type = $_POST["type"];

            $productsData = array();
            $productsData[0] = session('user');
            $productsData[1] = $type;

            $product = new Products();
            $product->id_user = $productsData[0];
            $product->type = $productsData[1];
            $product->save();


            $productType = array();

            $productType[0] = $_POST["name"];
            $productType[1] = $_POST["description"];
            $productType[2] = $_POST["subtype"];
            $productType[3] = $_POST["price"];
            $productType[4] = $_POST["stock"];
            $productType[5] = $_POST["date"];
            if($productsData[1] == "Paquetes"){

                $paquete = new Paquetes();
                $paquete->id_product = $product->id;
                $paquete->name = $productType[0];
                $paquete->description = $productType[1];
                $paquete->type = $productType[2];
                $paquete->price = $productType[3];
                $paquete->stock = $productType[4];
                $paquete->date = $productType[5];
                $paquete->save();

            }elseif($productsData[1] == "Cruceros") {

                $cruise = new Cruceros();
                $cruise->id_product = $product->id;
                $cruise->name = $productType[0];
                $cruise->description = $productType[1];
                $cruise->type = $productType[2];
                $cruise->price = $productType[3];
                $cruise->stock = $productType[4];
                $cruise->date = $productType[5];
                $cruise->save();

            }elseif ($productsData[1] == "Actividades") {
                $activity = new Actividades();
                $activity->id_product = $product->id;
                $activity->name = $productType[0];
                $activity->description = $productType[1];
                $activity->type = $productType[2];
                $activity->price = $productType[3];
                $activity->stock = $productType[4];
                $activity->date = $productType[5];
                $activity->save();

            }elseif ($productsData[1] == "Escolares") {
                $escolares = new Escolares();
                $escolares->id_product = $product->id;
                $escolares->name = $productType[0];
                $escolares->description = $productType[1];
                $escolares->type = $productType[2];
                $escolares->price = $productType[3];
                $escolares->stock = $productType[4];
                $escolares->date = $productType[5];
                $escolares->save();

            }else{
                return redirect('/shopAdmin')->with('error', 'Tipo de Producto no disponible');
            }

            return redirect('/shopAdmin')->with('exito','Se ha añadido el producto ' . $_POST['name']);
        }else{
            return redirect('/shopAdmin')->with('error','No se ha añadido el producto ' . $_POST['name']);
        }
    }

    public function eliminarProducto()
    {
        if (isset($_GET['idProducto'])) {
            Products::where('id', $_GET['idProducto'])->first()->delete();

            return redirect('/shopAdmin')->with('exito','Se ha eliminado el producto correctamente');
        }
    }

    public function actualizarProducto()
    {
        if (isset($_GET['idProducto'])) {
            return view('actualizarProducto', ['id' => $_GET['idProducto']]);
        }
    }


    public function procesar_producto_actualizado(){
        if(isset($_POST['idProducto'],$_POST['typeProducto'])) {

            if($_POST['typeProducto'] == 'Paquetes') {
                $paquete = Paquetes::where('id_product', $_POST['idProducto'])->first();

                if ($_POST['name'] != "") {
                    $paquete->name = $_POST['name'];
                }
                if ($_POST['description'] != "") {
                    $paquete->description = $_POST['description'];
                }
                if ($_POST['price'] != "") {
                    $paquete->price = doubleval($_POST['price']);
                }
                if ($_POST['date'] != "") {
                    $paquete->date = $_POST['date'];
                }
                if ($_POST['stock'] != "") {
                    $paquete->stock = $_POST['stock'];
                }
                if ($_POST['subtype'] != "") {
                    $paquete->type = $_POST['subtype'];
                }
                $paquete->save();
                return redirect('/shopAdmin')->with('exito','Se ha editado el producto ' . $paquete->name . ' correctamente');


            }elseif ($_POST['typeProducto'] == 'Cruceros'){
                $cruise = Cruceros::where('id_product', $_POST['idProducto'])->first();

                if ($_POST['name'] != "") {
                    $cruise->name = $_POST['name'];
                }
                if ($_POST['description'] != "") {
                    $cruise->description = $_POST['description'];
                }
                if ($_POST['price'] != "") {
                    $cruise->price = doubleval($_POST['price']);
                }
                if ($_POST['date'] != "") {
                    $cruise->date = $_POST['date'];
                }
                if ($_POST['stock'] != "") {
                    $cruise->stock = $_POST['stock'];
                }
                if ($_POST['subtype'] != "") {
                    $cruise->type = $_POST['subtype'];
                }
                $cruise->save();
                return redirect('/shopAdmin')->with('exito','Se ha editado el producto ' . $cruise->name . ' correctamente');

            }elseif ($_POST['typeProducto'] == 'Actividades') {
                $activities = Actividades::where('id_product', $_POST['idProducto'])->first();

                if ($_POST['name'] != "") {
                    $activities->name = $_POST['name'];
                }
                if ($_POST['description'] != "") {
                    $activities->description = $_POST['description'];
                }
                if ($_POST['price'] != "") {
                    $activities->price = doubleval($_POST['price']);
                }
                if ($_POST['date'] != "") {
                    $activities->date = $_POST['date'];
                }
                if ($_POST['stock'] != "") {
                    $activities->stock = $_POST['stock'];
                }
                if ($_POST['subtype'] != "") {
                    $activities->type = $_POST['subtype'];
                }
                $activities->save();
                return redirect('/shopAdmin')->with('exito', 'Se ha editado el producto ' . $activities->name . ' correctamente');
            }elseif ($_POST['typeProducto'] == 'Escolares') {
                $escolares = Escolares::where('id_product', $_POST['idProducto'])->first();

                if ($_POST['name'] != "") {
                    $escolares->name = $_POST['name'];
                }
                if ($_POST['description'] != "") {
                    $escolares->description = $_POST['description'];
                }
                if ($_POST['price'] != "") {
                    $escolares->price = doubleval($_POST['price']);
                }
                if ($_POST['date'] != "") {
                    $escolares->date = $_POST['date'];
                }
                if ($_POST['stock'] != "") {
                    $escolares->stock = $_POST['stock'];
                }
                if ($_POST['subtype'] != "") {
                    $escolares->type = $_POST['subtype'];
                }
                $escolares->save();
                return redirect('/shopAdmin')->with('exito', 'Se ha editado el producto ' . $escolares->name . ' correctamente');
            }
        }
    }


}
