<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
//以下　Register.vueを参考に
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
  order: { tyoe: Object },
});

const handleSubmit = () => {};
console.log(props);
</script>

<template>
  <Head title="オーダー詳細" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーダー詳細</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">オーダー詳細</div>
        </div>

        <div class="mt-3 mb-3 ml-3 flex">
          <Link
            :href="route('orders.index')"
            :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'"
          >
            <i class="fa-solid fa-backward"></i>
            戻る
          </Link>
        </div>

        <form @submit.prevent="submit" class="w-3/4">
          <div class="">
            <InputLabel for="order_id" value="ID" />
            <div class="ml-2 font-semibold text-xl">{{ props.order.data.id }}</div>
          </div>
          <div class="mt-4">
            <InputLabel for="order_id" value="注文日" />
            <div class="ml-2 font-semibold text-xl">{{ props.order.data.orderday }}</div>
          </div>
          <div class="mt-4">
            <InputLabel for="customer_id" value="客先" />
            <div class="ml-2 font-semibold text-xl">{{ props.order.data.customer.name }}</div>
          </div>
          <!--ここから商品1-->
          <div class="mt-4 flex">
            <div>
              <InputLabel for="product_id1" value="商品1" />
              <div class="ml-2 font-semibold text-xl w-40">
                {{ props.order.data.product1.name }}
              </div>
            </div>
            <div class="flex">
              <div class="ml-10 w-24">
                <InputLabel value="コード" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product1.code }}
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="価格" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product1.price }}円
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="税率" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product1.tax }}%
                </div>
              </div>
            </div>
            <div class="ml-10">
              <InputLabel for="num1" value="注文数" />
              <div class="mt-3 ml-2 font-medium text-xl">{{ props.order.data.num1 }}%</div>
            </div>
          </div>
          <!--ここまで商品1-->
          <!--ここから商品2-->
          <div v-if="props.order.data.product2?.name" class="mt-4 flex">
            <div>
              <InputLabel for="product_id2" value="商品2" />
              <div class="ml-2 font-semibold text-xl w-40">
                {{ props.order.data.product2.name }}
              </div>
            </div>
            <div class="flex">
              <div class="ml-10 w-24">
                <InputLabel value="コード" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product2.code }}
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="価格" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product2.price }}円
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="税率" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product2.tax }}%
                </div>
              </div>
            </div>
            <div class="ml-10">
              <InputLabel for="num1" value="注文数" />
              <div class="mt-3 ml-2 font-medium text-xl">{{ props.order.data.num2 }}%</div>
            </div>
          </div>
          <!--ここまで商品2-->
          <!--ここから商品3-->
          <div v-if="props.order.data.product3?.name" class="mt-4 flex">
            <div>
              <InputLabel for="product_id3" value="商品3" />
              <div class="ml-2 font-semibold text-xl w-40">
                {{ props.order.data.product3.name }}
              </div>
            </div>
            <div class="flex">
              <div class="ml-10 w-24">
                <InputLabel value="コード" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product3.code }}
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="価格" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product3.price }}円
                </div>
              </div>
              <div class="ml-10 w-24">
                <InputLabel value="税率" />
                <div class="mt-3 ml-2 font-medium text-xl">
                  {{ props.order.data.product3.tax }}%
                </div>
              </div>
            </div>
            <div class="ml-10">
              <InputLabel for="num1" value="注文数" />
              <div class="mt-3 ml-2 font-medium text-xl">{{ props.order.data.num3 }}%</div>
            </div>
          </div>
          <!--ここまで商品3-->

          <div class="flex items-center mt-8 mb-8">
            <PrimaryButton class="ms-4" @click="handleSubmit">請求書発行</PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
