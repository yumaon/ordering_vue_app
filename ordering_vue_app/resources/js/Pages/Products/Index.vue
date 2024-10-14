<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  products: {type:Object}
});

const form = useForm({
  id: '',
});

const deleteProduct = (id, name) => {
  if(confirm("Are you sure to delete " + name + "?")) {
    form.delete(route('products.destroy', id));
  }
};
</script>

<template>
  <Head title="Products" />

  <AuthenticatedLayout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  <div class="p-6 text-gray-900">商品一覧</div>
              </div>
          </div>

          <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

              <div class="mt-3 mb-3 ml-3 flex">
                <Link :href="route('products.create')" :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'" >
                  <i class="fa-solid fa-plus-circle"></i> 商品登録
                </Link>
              </div>    


              <table class="table-auto border border-gray-400 w-10/12 m-3">
                <thead>
                  <tr class="bg-gray-100">
                    <th class="px-4 py-2 w-12">ID</th>
                    <th class="px-4 py-2 w-48">商品</th>
                    <th class="px-4 py-2 w-28">コード</th>
                    <th class="px-4 py-2 w-28 text-center">価格</th>
                    <th class="px-4 py-2 w-28 text-center">税率</th>
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="product in products" :key="product.id">
                      <td class="border border-gray-400 px-4 py-2 text-center">{{ product.id }}</td>
                      <td class="border border-gray-400 px-4 py-2">{{ product.name }}</td>
                      <td class="border border-gray-400 px-4 py-2 text-center">{{ product.code }}</td>
                      <td class="border border-gray-400 px-4 py-2 text-right">{{ product.price }}</td>
                      <td class="border border-gray-400 px-4 py-2 text-right">{{ product.tax }}%</td>
                      <td class="border border-gray-400 px-4 py-2 text-center">
                        <Link :href="route('products.edit', product.id)" :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md text-xs'">
                          <i class="fa-solid fa-edit"></i> 
                        </Link>
                      </td>
                      <td class="border border-gray-400 px-4 py-2 text-center">
                        <DangerButton @click="deleteProduct(product.id, product.name)">
                          <i class="fa-solid fa-trash"></i>
                        </DangerButton>
                      </td>
                  </tr>
                </tbody>
              </table>   
            </div>
          </div>

      </div>
  </AuthenticatedLayout>
</template>

