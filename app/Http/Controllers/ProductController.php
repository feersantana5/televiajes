<?php

namespace App\Http\Controllers;

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

    public function numero_productos()
    {
        $productos = Products::all();
        $numeroProdictos = count($productos);
        echo $numeroProdictos;
    }

    public function listaProductos()
    {
        $products = Products::get();
        $paquetes = Paquetes::get();

        return view('/shopAdmin')
            ->with('products', $products)
            ->with('paquetes', $paquetes);
    }

    public function listaPaquetes()
    {
        $products = Products::get();
        $paquetes = Paquetes::get();

        return view('/paquetes')
            ->with('products', $products)
            ->with('paquetes', $paquetes);
    }


    public function addProducto(){
        if (isset($_POST["type"], $_POST["name"], $_POST["description"], $_POST["subtype"], $_POST["price"], $_POST["stock"])) {

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

            if($productsData[1] == "Paquetes"){
                $paquete = new Paquetes();
            } else{
                return redirect('/shopAdmin')->with('error', 'Tipo no disponible');
            }

            $paquete->id_product = $product->id;
            $paquete->name = $productType[0];
            $paquete->description = $productType[1];
            $paquete->type = $productType[2];
            $paquete->price = $productType[3];
            $paquete->stock = $productType[4];

            $paquete->save();

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

    /**
     *
     * TODO: FER ECHALE UN OJO PELOTUDO
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function actualizarProducto()
    {
        if (isset($_GET['idProducto'])) {
            return view('actualizarProducto', ['id' => $_GET['idProducto']]);
        }
    }

    /**
     * TODO: FER ECHALE UN OJO PELOTUDO
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function procesar_producto_actualizado(){
        if(isset($_POST['idProducto'])) {
            $producto = Products::where('id',$_POST['idProducto'])->first();

            if ($_POST['nombreProducto'] != "") {
                $producto->nombreProducto = $_POST['nombreProducto'];
            }
            if ($_POST['descripcionProducto'] != "") {
                $producto->descripcionProducto = $_POST['descripcionProducto'];
            }
            if ($_POST['precioProducto'] != "") {
                $producto->precioProducto = doubleval($_POST['precioProducto']);
            }
            if ($_POST['stockProducto'] != "") {
                $producto->stockProducto = doubleval($_POST['stockProducto']);
            }
            $producto->save();
            return redirect('/shopAdmin')->with('exito','Se ha editado el producto ' . $producto->nombreProducto . ' correctamente');
        }
    }

}
