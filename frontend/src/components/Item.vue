<script setup lang="ts">
import axios from 'axios'

const props = defineProps({
  id: { type: String, required: true },
  sku: String,
  title: String,
  image: String,
  description: String,
  price: String,
  category: String
})

function deleteItem(id: String) {
  axios.get(`http://localhost:8000/?borrar=${id}`).then((res) => {
    console.log(res)
  })
}
</script>
<template>
  <ul class="styled-list">
    <li>{{ id }}</li>
    <li>{{ sku }}</li>
    <li>{{ title }}</li>
    <li>{{ image }}</li>
    <li class="large">{{ description }}</li>
    <li>{{ price }}</li>
    <li>{{ category }}</li>
    <li class="btn"><button :onclick="() => deleteItem(props.id)">Eliminar</button></li>
    <li class="btn"><button>Editar</button></li>
  </ul>
</template>

<style scoped>
ul.styled-list {
  list-style-type: none;
  padding: 10px;
  margin: 0;
  border-radius: 10px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);

  display: flex;
  justify-content: space-evenly;
  box-sizing: border-box;
  width: 100%;
  margin-bottom: 10px;
}
ul.styled-list li {
  padding: 5px;
  width: 100px;
  display: flex;
  justify-content: start;
  align-items: center;
}

ul.styled-list li.btn {
  justify-content: center;
  align-items: center;
}

ul.styled-list li.large {
  width: 250px;
}
</style>
