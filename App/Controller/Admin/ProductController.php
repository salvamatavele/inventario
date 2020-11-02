<?php

namespace App\Controller\Admin;

use App\Model\User;
use App\Model\Color;
use App\Model\Product;
use Resource\Paginate;
use App\Model\Category;
use App\Model\Location;
use Resource\Validator;
use Resource\FileManager;
use Resource\Authentication;
use App\Controller\Controller;

class ProductController extends Controller
{
    public function __construct($router, $dir = __DIR__ . "/../../../Source/template/admin/product/")
    {
        Authentication::permition(['superadmin', 'admin']);
        parent::__construct($router, $dir);
    }

    public function index()
    {
        $files = (new Product);
        $user = (new User)->findById($_SESSION['id']);
        $paginate = new Paginate;
        $data = $paginate->paginate($files, 5, 3, "<i class='material-icons small'>keyboard_arrow_left</i>", "<i class='material-icons small'>keyboard_arrow_right</i>");
        $category = (new Category)->find()->fetch(true);
        $location = (new Location)->find()->fetch(true);
        $color = (new Color)->find()->fetch(true);

        echo $this->view->render('index', [
            'title' => 'Produtos',
            'products' => $data,
            'categories' => $category,
            'locations' => $location,
            'colores'=>$color,
            'user'=>$user,
            'paginate' => $paginate->paginator()
        ]);
    }

    public function store(array $data)
    {
        $stock = filter_var($data['stock'], FILTER_VALIDATE_INT);

        $validate = new Validator();
        $validate->isNumber($stock, 'The stock is number required field.');
        $validate->validateFields($data);
        if (!empty($validate->getErrors())) {
            echo \json_encode(['errors' => $validate->getErrors()]);
            return;
        }
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $color = filter_var($data['color'], FILTER_SANITIZE_STRING);
        $description = filter_var($data['description'], FILTER_SANITIZE_STRING);


        $upload = new FileManager();

        $uploaded = $upload->uploadSingleImage($data);
        
        if ($uploaded) {
            $product = new Product();
            $product->name = $name;
            $product->stock = $stock;
            $product->color_id = $color;
            $product->status = $data['status'];
            $product->category_id = $data['category'];
            $product->location_id = $data['location'];
            $product->description = $description;
            $product->image = $upload->getUploadedPath();
            $save = $product->save();
            if (!$save) {
                $upload->deleteFiles($upload->getUploadedPath());
                echo json_encode(['errors' => 'Falha ao tentar registar o produto.']);
                return;
            }
            echo \json_encode(['success' => 'Produto registado com successo.']);
            return;
        } else {
            echo json_encode(['errors' => $upload->getError()]);
            return;
        }
    }

    public function show(array $data)
    {
        $product = (new Product())->findById($data['id'])->data();
        $category = (new Category())->findById($product->category_id)->data();
        $location = (new Location())->findById($product->location_id)->data();
        
        if ($product->color_id == null) {
            echo  \json_encode(['product' => $product, 'category' => $category, 'location' => $location, 'color'=>'Indefinida']);
            return;
        }else{
            $color =(new Color())->findById($product->color_id)->data();
            echo  \json_encode(['product' => $product, 'category' => $category, 'location' => $location, 'color'=>$color]);
            return;
        }
    }


    public function edit(array $data)
    {
        $product = (new Product())->findById($data['id'])->data();

        echo  \json_encode(['product' => $product]);

        return;
    }


    public function update(array $data)
    {
        $product = (new Product)->findById($data['id']);
        $validate = new Validator;
        $validate->validateFields(['name' => $data['name'], 'stock' => $data['stock'], 'category' => $data['category'], 'location' => $data['location'], 'status' => $data['status'], 'description' => $data['description']]);
        $stock = filter_var($data['stock'], FILTER_VALIDATE_INT);
        $validate->isNumber($stock, 'The stock is number required field.');
        if (!empty($validate->getErrors())) {
            # code...
            $error = $validate->getErrors();
            echo json_encode(['errors' => $error]);
            return;
        } else {
            $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
            $description = filter_var($data['description'], FILTER_SANITIZE_STRING);
            if (empty($data['image'])) {
                $product->name = $name;
                $product->stock = $stock;
                $product->color_id = $data['color'];
                $product->status = $data['status'];
                $product->category_id = $data['category'];
                $product->location_id = $data['location'];
                $product->description = $description;
                $save = $product->save();
                if (!$save) {
                    echo json_encode(['errors' => 'Falha ao tentar atualizar o produto.' . $product->name]);
                    return;
                }
                echo json_encode(['success' => 'Produto atualizado com sucesso.']);
                return;
            } else {
                $upload = new FileManager();

                $uploaded = $upload->uploadSingleImage($data);
                if ($uploaded) {
                    $product->name = $name;
                    $product->stock = $stock;
                    $product->color_id = $data['color'];
                    $product->status = $data['status'];
                    $product->category_id = $data['category'];
                    $product->location_id = $data['location'];
                    $product->description = $description;
                    $product->image = $upload->getUploadedPath();
                    $save = $product->save();
                    if (!$save) {
                        (new FileManager)->deleteFiles($upload->getUploadedPath());
                        echo json_encode(['errors' => 'Falha ao tentar atualizar o produto.'.$product->name]);
                        return;
                    }
                    echo json_encode(['success' => 'produto atualizado com sucesso.']);
                    return;
                } else {
                    echo json_encode(['errors' => $upload->getError()]);
                    return;
                }
            }
        }
    }


    public function destroy(array $data)
    {
        $product = (new Product())->findById($data['id']);
        if ($product->destroy()) {
            (new FileManager())->deleteFiles($product->image);
            echo json_encode(['success' => 'Produto eliminado com sucesso.']);
        } else {
            echo json_encode(['error' => 'Falha ao tentar eliminar produto ' . $product->name]);
        }
    }

    public function search(array $data)
    {
        $params = http_build_query(["name" => '%' . $data['search'] . '%']);
        $files = (new Product)->find("LOWER(name) like LOWER(:name)", $params)->fetch(true);
        if (!$files) {
            echo "<h4 class='center'>Nenhum iten encontrado.</h4>";
        } else {
            foreach ($files as $product) {
                echo "
                <tr>
              <td><img src='". url($product->image)."' width='30' srcset='{$product->name}'> </td>
              <td>{$product->name }</td>
              <td>{$product->status }</td>
              <td>{$product->stock }</td>
              <td>
                <a name='view' class='view waves-effect waves-teal ' id='{$product->id }'><i class='material-icons left teal-text'>remove_red_eye</i></a>
                <a name='edit' class='edit waves-effect waves-teal ' id='{$product->id }'><i class='material-icons left green-text'>edit</i></a>
                <a name='delete' class='delete waves-effect waves-teal ' id='{$product->id }'><i class='material-icons left red-text'>delete</i></a>
              </td>
            </tr>
                ";
            }
        }
    }
}
