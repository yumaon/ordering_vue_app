<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';
// 検索機能のために追記
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
  products: {type:Object},
  search_str: String,
  successMessage: String,
});
const successMessage = props.successMessage;

const form = useForm({
  id: '',
  search_str: props.search_str || '',
});

const deleteProduct = (id, name) => {
  if(confirm("Are you sure to delete " + name + "?")) {
    form.delete(route('products.destroy', id));
  }
};

const search_go = () => {
  form.get(route('products.index'))
};

console.log(props.products.data.length);
console.log(props.products);
const products_count = props.products.data.length;
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
                <div>
                  <TextInput
                    id="search_str"
                    type="text"
                    class="block w-full"
                    v-model="form.search_str"
                    autocomplete="search_str"
                    @blur="search_go"
                  />
                </div>
                <span v-if="products_count === 0" class="m-2">該当する商品がありません。</span>
                <span v-else class="m-2">商品件数： {{ products_count }} 件</span>
              </div>    

              <div v-if="successMessage" class="bg-red-100 p-3 m-3 w-48">
                {{ successMessage }}
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
                  <tr v-for="product in products.data" :key="product.id">
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
              <!-- Pagination -->
              <nav class="flex items-center gap-x-1 mt-2 mb-2" aria-label="Pagination">
                <div class="flex items-center gap-x-1">
                    <div v-for="(link, index) in products.links" :key="index">

                        <!-- Previous button -->
                        <div v-if="index == 0">
                            <Link 
                                :href="route('products.index', { page: products.current_page - 1, search_str: form.search_str })"
                                type="button" 
                                class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10">
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                                <span>Previous</span>
                            </Link>
                        </div>

                        <!-- Next button -->
                        <div v-else-if="index == products.links.length - 1">
                            <Link 
                                :href="route('products.index', { page: products.current_page + 1, search_str: form.search_str })"
                                type="button" 
                                class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10">
                                <span>Next</span>
                                <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </Link>
                        </div>

                        <!-- Numbered page buttons -->
                        <div v-else>
                            <!-- Active page button -->
                            <Link 
                                :href="route('products.index', { page: link.label, search_str: form.search_str })"
                                v-if="link.active"
                                type="button" 
                                class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none" 
                                aria-current="page">
                                <span>{{ link.label }}</span>
                            </Link>

                            <!-- Inactive page button -->
                            <Link 
                                :href="route('products.index', { page: link.label, search_str: form.search_str })"
                                v-else
                                type="button" 
                                class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10">
                                <span>{{ link.label }}</span>
                            </Link>
                        </div>

                    </div>
                </div>
              </nav>
              <!-- End Pagination -->            
            </div>
          </div>

      </div>
  </AuthenticatedLayout>
</template>

