<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Database connection
$servername = "localhost:3306";
$username = "admin";
$password = "admin";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the appropriate request method
$method = $_SERVER['REQUEST_METHOD'];

// Handle the request
switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
    case 'POST':
        handlePostRequest();
        break;
    case 'PUT':
        handlePutRequest();
        break;
    case 'DELETE':
        handleDeleteRequest();
        break;
    default:
        echo json_encode(['message' => 'Method not allowed']);
        break;
}

// Handle GET request
function handleGetRequest()
{
    global $conn;

    // Get all products
    if (!isset($_GET['id'])) {
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $products = array();

            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }

            echo json_encode($products);
        } else {
            echo json_encode([]);
        }
    }
    // Get a specific product by its ID
    else {
        $id = $_GET['id'];

        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo json_encode($product);
        } else {
            echo json_encode(['message' => 'Product not found']);
        }
    }
}

// Handle POST request
function handlePostRequest()
{
    global $conn;

    // Get the POST data
    $data = json_decode(file_get_contents("php://input"), true);

    $sku = $data['sku'];
    $title = $data['title'];
    $image = $data['image'];
    $description = $data['description'];
    $price = $data['price'];
    $category = $data['category'];

    $sql = "INSERT INTO products (sku, title, image, description, price, category) VALUES ('$sku', '$title', '$image', '$description', '$price', '$category')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Product created successfully']);
    } else {
        echo json_encode(['message' => 'Error creating product: ' . $conn->error]);
    }
}

// Handle PUT request
function handlePutRequest()
{
    global $conn;

    // Get the PUT data
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $_GET['id'];

    $sku = $data['sku'];
    $title = $data['title'];
    $image = $data['image'];
    $description = $data['description'];
    $price = $data['price'];
    $category = $data['category'];

    $sql = "UPDATE products SET sku='$sku', title='$title', image='$image', description='$description', price='$price', category='$category' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Product updated successfully']);
    } else {
        echo json_encode(['message' => 'Error updating product: ' . $conn->error]);
    }
}

// Handle DELETE request
function handleDeleteRequest()
{
    global $conn;

    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Product deleted successfully']);
    } else {
        echo json_encode(['message' => 'Error deleting product: ' . $conn->error]);
    }
}

$conn->close();
?>