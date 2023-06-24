<template>
  <div class="container">
    <h1>Product Management</h1>
    <form @submit.prevent="handleSubmit" v-if="!isEditing">
      <input type="text" v-model="product.sku" placeholder="SKU" required />
      <input type="text" v-model="product.title" placeholder="Title" required />
      <input type="text" v-model="product.image" placeholder="Image URL" required />
      <textarea v-model="product.description" placeholder="Description" required></textarea>
      <input type="number" v-model="product.price" placeholder="Price" required />
      <input type="text" v-model="product.category" placeholder="Category" required />
      <button type="submit">Add Product</button>
    </form>
    <form @submit.prevent="updateProduct" v-else>
      <input type="text" v-model="product.sku" placeholder="SKU" required />
      <input type="text" v-model="product.title" placeholder="Title" required />
      <input type="text" v-model="product.image" placeholder="Image URL" required />
      <textarea v-model="product.description" placeholder="Description" required></textarea>
      <input type="number" v-model="product.price" placeholder="Price" required />
      <input type="text" v-model="product.category" placeholder="Category" required />
      <button type="submit">Update Product</button>
    </form>
    <table v-if="products.length > 0">
      <thead>
        <tr>
          <th>SKU</th>
          <th>Title</th>
          <th>Price</th>
          <th>Category</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.sku }}</td>
          <td>{{ product.title }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.category }}</td>
          <td>
            <button @click="editProduct(product)">Edit</button>
            <button @click="deleteProduct(product.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-else>
      <p>No products found.</p>
    </div>

    <form @submit.prevent="searchProducts">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search products on MercadoLibre"
        required
      />
      <button type="submit">Search</button>
    </form>

    <div v-if="searchResults.length > 0">
      <h2>Search Results</h2>
      <ul>
        <li v-for="result in searchResults" :key="result.id">
          <div>{{ result.title }}</div>
          <div>Price: {{ result.price }}</div>
          <button @click="addProduct(result)">Add to Products</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'

interface Product {
  id: number
  sku: string
  title: string
  image: string
  description: string
  price: number
  category: string
}

export default defineComponent({
  name: 'HelloWorld',
  setup() {
    const products = ref<Product[]>([])
    const product = ref<Product>({
      id: 0,
      sku: '',
      title: '',
      image: '',
      description: '',
      price: 0,
      category: ''
    })
    const isEditing = ref<boolean>(false)
    const searchQuery = ref<string>('')
    const searchResults = ref<Product[]>([])

    const fetchProducts = () => {
      fetch('http://localhost:8000/')
        .then((response) => response.json())
        .then((data) => {
          products.value = data
        })
        .catch((error) => {
          console.error('Error fetching products:', error)
        })
    }

    const createProduct = () => {
      fetch('http://localhost:8000/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(product.value)
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data)
          resetForm()
          fetchProducts()
        })
        .catch((error) => {
          console.error('Error creating product:', error)
        })
    }

    const deleteProduct = (id: number) => {
      fetch(`http://localhost:8000/?id=${id}`, {
        method: 'DELETE'
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data)
          fetchProducts()
        })
        .catch((error) => {
          console.error('Error deleting product:', error)
        })
    }

    const editProduct = (product: Product) => {
      isEditing.value = true
      product = { ...product }
    }

    const updateProduct = () => {
      fetch(`http://localhost:8000/?id=${product.value.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(product.value)
      })
        .then((response) => response.json())
        .then((data) => {
          console.log(data)
          resetForm()
          fetchProducts()
        })
        .catch((error) => {
          console.error('Error updating product:', error)
        })
    }

    const resetForm = () => {
      product.value = {
        id: 0,
        sku: '',
        title: '',
        image: '',
        description: '',
        price: 0,
        category: ''
      }
      isEditing.value = false
    }

    const handleSubmit = () => {
      if (isEditing.value) {
        updateProduct()
      } else {
        createProduct()
      }
    }

    const searchProducts = () => {
      fetch(`https://api.mercadolibre.com/items/${searchQuery.value}`)
        .then((response) => response.json())
        .then((data) => {
          alert(data.title);
          searchResults.value = data.results
        })
        .catch((error) => {
          console.error('Error searching products:', error)
        })
    }

    onMounted(fetchProducts)

    return {
      products,
      product,
      isEditing,
      searchQuery,
      searchResults,
      fetchProducts,
      createProduct,
      deleteProduct,
      editProduct,
      updateProduct,
      resetForm,
      handleSubmit,
      searchProducts
    }
  }
})
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

form {
  margin-bottom: 20px;
}

input[type='text'],
textarea,
input[type='number'] {
  display: block;
  width: 100%;
  margin-bottom: 10px;
  padding: 5px;
}

button {
  padding: 10px 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

table td,
table th {
  padding: 8px;
  border-bottom: 1px solid #ddd;
}

table th {
  text-align: left;
}
</style>
