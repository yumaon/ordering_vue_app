<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
//以下　Register.vueを参考に
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
//追記　セレクトボックス選択時の処理のために追記
import { computed } from "vue";

const props = defineProps({
    products: { type: Object },
    customers: { type: Object },
});

const form = useForm({
    customer_id: "",
    product_id1: "",
    product_id2: "",
    product_id3: "",
    num1: "",
    num2: "",
    num3: "",
});
//商品選択時の処理
const selectedProduct1 = computed(() => {
    return props.products.find((product) => product.id === form.product_id1);
});
const selectedProduct2 = computed(() => {
    return props.products.find((product) => product.id === form.product_id2);
});
const selectedProduct3 = computed(() => {
    return props.products.find((product) => product.id === form.product_id3);
});

const submit = () => {
    //form.post(route('orders.store'), {
    //    onSuccess: () => form.reset('customer_id', 'product_id1', 'num1', 'product_id2', 'num2', 'product_id3', 'num3', ),
    //});
};
</script>

<template>
    <Head title="オーダー登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                オーダー登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">オーダー登録</div>
                </div>

                <div class="mt-3 mb-3 ml-3 flex">
                    <Link
                        :href="route('orders.index')"
                        :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'"
                    >
                        <i class="fa-solid fa-backward"></i> 戻る
                    </Link>
                </div>

                <form @submit.prevent="submit" class="w-3/4">
                    <div class="mt-4">
                        <InputLabel for="customer_id" value="客先" />
                        <SelectInput
                            :options="customers"
                            id="customer_id"
                            class="mt-1 block w-80"
                            v-model="form.customer_id"
                            required
                            autofocus
                            autocomplete="customer_id"
                        />
                        <InputError
                            class="mt-2"
                            :message="form.errors.customer"
                        />
                    </div>
                    <!--ここから商品1-->
                    <div class="mt-4 flex">
                        <div>
                            <InputLabel for="product_id1" value="商品1" />
                            <SelectInput
                                :options="products"
                                id="product_id1"
                                class="mt-1 block w-80"
                                v-model="form.product_id1"
                                required
                                autocomplete="product_id1"
                            />
                        </div>
                        <div v-if="selectedProduct1" class="flex">
                            <div class="ml-10 w-24">
                                <InputLabel value="コード" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct1.code }}
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="価格" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct1.price }}円
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="税率" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct1.tax }}%
                                </div>
                            </div>
                        </div>
                        <div v-if="selectedProduct1" class="ml-10">
                            <InputLabel for="num1" value="注文数" />
                            <TextInput
                                id="num1"
                                type="number"
                                class="mt-1 block w-36"
                                v-model="form.num1"
                                required
                                autocomplete="num1"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.num1"
                            />
                        </div>
                    </div>
                    <!--ここまで商品1-->
                    <!--ここから商品2-->
                    <div class="mt-4 flex">
                        <div>
                            <InputLabel for="product_id2" value="商品2" />
                            <SelectInput
                                :options="products"
                                id="product_id2"
                                class="mt-1 block w-80"
                                v-model="form.product_id2"
                                autocomplete="product_id2"
                            />
                        </div>
                        <div v-if="selectedProduct2" class="flex">
                            <div class="ml-10 w-24">
                                <InputLabel value="コード" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct2.code }}
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="価格" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct2.price }}円
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="税率" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct2.tax }}%
                                </div>
                            </div>
                        </div>
                        <div v-if="selectedProduct2" class="ml-10">
                            <InputLabel for="num2" value="注文数" />
                            <TextInput
                                id="num2"
                                type="number"
                                class="mt-1 block w-36"
                                v-model="form.num2"
                                required
                                autocomplete="num2"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.num2"
                            />
                        </div>
                    </div>
                    <!--ここまで商品2-->
                    <!--ここから商品3-->
                    <div class="mt-4 flex">
                        <div>
                            <InputLabel for="product_id3" value="商品3" />
                            <SelectInput
                                :options="products"
                                id="product_id3"
                                class="mt-1 block w-80"
                                v-model="form.product_id3"
                                autocomplete="product_id3"
                            />
                        </div>
                        <div v-if="selectedProduct3" class="flex">
                            <div class="ml-10 w-24">
                                <InputLabel value="コード" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct3.code }}
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="価格" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct3.price }}円
                                </div>
                            </div>
                            <div class="ml-10 w-24">
                                <InputLabel value="税率" />
                                <div class="mt-3 ml-2 font-medium text-xl">
                                    {{ selectedProduct3.tax }}%
                                </div>
                            </div>
                        </div>
                        <div v-if="selectedProduct3" class="ml-10">
                            <InputLabel for="num2" value="注文数" />
                            <TextInput
                                id="num3"
                                type="number"
                                class="mt-1 block w-36"
                                v-model="form.num3"
                                required
                                autocomplete="num3"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.num3"
                            />
                        </div>
                    </div>
                    <!--ここまで商品3-->

                    <div class="flex items-center mt-8 mb-8">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            登録
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
