<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
//次の一行　検索機能のために追記
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  orders: { type: Object },
  search_str: String,
  successMessage: String,
});
const successMessage = props.successMessage;

const form = useForm({
  id: "",
  search_str: props.search_str || "",
});
const deleteOrder = (id, name) => {
  // if (confirm("Are you sure to delete " + name + "?")) {
  // }
  if (confirm("Are you sure to delete OrderID: " + id + "?")) {
    form.delete(route("orders.destroy", id), {
      preserveScroll: true,
    });
  }
};
const search_go = () => {
  form.get(route("orders.index"));
};

console.log(props.orders.data.length);
console.log(props.orders);
props.orders.data.forEach((order, index) => {
  console.log(`Order ${index + 1}:`, order);
  console.log(`Customer:`, order.customer);
  console.log(`Product1:`, order.product1);
  console.log(`Product2:`, order.product2);
  console.log(`Product3:`, order.product3);
});
</script>

<template>
  <Head title="オーダー情報" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーダー情報</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">オーダー一覧</div>
        </div>
      </div>

      <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
          <div class="mt-3 mb-3 ml-3 flex">
            <Link
              :href="route('orders.create')"
              :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'"
            >
              <i class="fa-solid fa-plus-circle"></i>
              オーダー登録
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
            <span v-if="props.orders.data.length === 0" class="m-2">
              該当する顧客はありません。
            </span>
          </div>

          <div v-if="successMessage" class="bg-red-100 p-3 m-3 w-48">
            {{ successMessage }}
          </div>

          <table class="table-auto border border-gray-400 w-100 m-3">
            <thead>
              <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2 text-xs">受注日</th>
                <th class="px-4 py-2 text-xs">顧客</th>
                <th class="px-4 py-2 text-xs">商品1</th>
                <th class="px-4 py-2 text-xs">単価</th>
                <th class="px-4 py-2 text-xs">税率</th>
                <th class="px-1 py-2 text-xs">注文数</th>
                <th class="px-4 py-2 text-xs">商品2</th>
                <th class="px-4 py-2 text-xs">単価</th>
                <th class="px-4 py-2 text-xs">税率</th>
                <th class="px-1 py-2 text-xs">注文数</th>
                <th class="px-4 py-2 text-xs">商品3</th>
                <th class="px-4 py-2 text-xs">単価</th>
                <th class="px-4 py-2 text-xs">税率</th>
                <th class="px-1 py-2 text-xs">注文数</th>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders.data" :key="order.id">
                <td class="border border-gray-400 px-4 py-2 text-center">
                  {{ order.id }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center text-xs">
                  {{ order.orderday }}
                </td>
                <td class="border border-gray-400 px-4 py-2">
                  {{ order.customer.name }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product1.name }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product1.price }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product1.tax }}%
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.num1 }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product2?.name }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product2?.price }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product2?.tax }}{{ order.product2 ? "%" : "" }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.num2 }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product3?.name }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product3?.price }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.product3?.tax }}{{ order.product3 ? "%" : "" }}
                </td>
                <td class="border border-gray-400 px-2 py-2 text-center">
                  {{ order.num3 }}
                </td>
                <td class="border border-gray-400 px-4 py-2 text-center">
                  <Link
                    :href="
                      route('orders.show', {
                        order: order.id,
                        page: orders.meta.current_page,
                        search_str: form.search_str,
                      })
                    "
                    :class="'px-4 py-2 bg-green-400 text-white border rounded-md text-xs inline-block text-center'"
                  >
                    <i class="fa-solid fa-info"></i>
                  </Link>
                </td>
                <td class="border border-gray-400 px-4 py-2 text-center">
                  <Link
                    :href="route('orders.edit', order.id)"
                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md text-xs inline-block text-center'"
                  >
                    <i class="fa-solid fa-edit"></i>
                  </Link>
                </td>
                <td class="border border-gray-400 px-4 py-2 text-center">
                  <DangerButton @click="deleteOrder(order.id, order.name)">
                    <i class="fa-solid fa-trash"></i>
                  </DangerButton>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <nav class="flex items-center gap-x-1 mt-2 mb-2" aria-label="Pagination">
            <div class="flex items-center gap-x-1">
              <div v-for="(link, index) in orders.meta.links">
                <div v-if="index == 0">
                  <Link
                    :href="
                      route('orders.index', {
                        page: orders.meta.current_page - 1,
                        search_str: form.search_str,
                      })
                    "
                    v-show="link['url'] != null"
                    type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10"
                  >
                    <svg
                      class="shrink-0 size-3.5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path d="m15 18-6-6 6-6"></path>
                    </svg>
                    <span>Previous</span>
                  </Link>
                </div>
                <div v-else-if="index == orders.meta.last_page + 1">
                  <Link
                    :href="
                      route('orders.index', {
                        page: orders.meta.current_page + 1,
                        search_str: form.search_str,
                      })
                    "
                    v-show="link['url'] != null"
                    type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10"
                  >
                    <span>Next</span>
                    <svg
                      class="shrink-0 size-3.5"
                      xmlns="http://www.w3.org/2000/svg"
                      width="24"
                      height="24"
                      viewBox="0 0 24 24"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    >
                      <path d="m9 18 6-6-6-6"></path>
                    </svg>
                  </Link>
                </div>
                <div v-else>
                  <Link
                    :href="
                      route('orders.index', {
                        page: link['label'],
                        search_str: form.search_str,
                      })
                    "
                    v-if="link['active'] === true"
                    v-show="link['url'] != null"
                    type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none"
                    aria-current="page"
                  >
                    <span>{{ link["label"] }}</span>
                  </Link>
                  <Link
                    :href="
                      route('orders.index', {
                        page: link['label'],
                        search_str: form.search_str,
                      })
                    "
                    v-else
                    v-show="link['url'] != null"
                    type="button"
                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:hover:bg-white/10 dark:focus:bg-white/10"
                  >
                    <span>{{ link["label"] }}</span>
                  </Link>
                </div>
              </div>
            </div>
          </nav>
          <!-- End Pagination -->

          <div></div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
