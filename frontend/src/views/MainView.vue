<script setup lang="ts">
import axios from 'axios'
import { ref } from 'vue'
import Item from '@/components/Item.vue'

interface Product {
  id: string
  sku: string
  title: string
  image: string
  description: string
  price: string
  category: string
}

interface Producto {
  sku: string
  title: string
  image: string
  description: string
  price: number
  category: string
}

const producto = ref<Producto>({
  sku: '',
  title: '',
  image: '',
  description: '',
  price: 0,
  category: ''
})

const products = ref<Product[]>([])

const guardarProducto = () => {
  console.log(producto.value)

  axios.post('http://localhost:8000/?insertar', producto.value).then((res) => {
    alert(res.status);
  })

  producto.value = {
    sku: '',
    title: '',
    image: '',
    description: '',
    price: 0,
    category: ''
  }
}

axios.get('http://localhost:8000/').then((res) => {
  products.value = res.data
})
</script>
<template>
  <div>
    <form @submit="guardarProducto">
      <label for="sku">SKU:</label>
      <input type="text" v-model="producto.sku" required /><br />

      <label for="title">Título:</label>
      <input type="text" v-model="producto.title" required /><br />

      <label for="image">Imagen:</label>
      <input type="text" v-model="producto.image" required /><br />

      <label for="description">Descripción:</label>
      <textarea v-model="producto.description" required></textarea><br />

      <label for="price">Precio:</label>
      <input type="number" v-model="producto.price" step="0.01" required /><br />

      <label for="category">Categoría:</label>
      <input type="text" v-model="producto.category" required /><br />

      <button type="submit">Guardar</button>
    </form>
    <Item
      v-for="product in products"
      :id="product.id"
      :sku="product.sku"
      :title="product.title"
      :image="product.image"
      :description="product.description"
      :price="product.price"
      :category="product.category"
    />
  </div>
</template>

<style scoped></style>
