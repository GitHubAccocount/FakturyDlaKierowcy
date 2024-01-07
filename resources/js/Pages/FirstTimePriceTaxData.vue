<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";

const form = useForm({
    price: "",
    tax: "",
});

const submit = () => {
    form.post(route("tax.price.store"));
};
</script>

<template>
    <Head title="Cena/Podatki" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div>
                                <p class="text-xl mb-6 font-bold">
                                    Uzupełnij poniższe dane:
                                </p>
                            </div>
                            <div>
                                <div class="mt-3">
                                    <InputLabel
                                        for="price"
                                        value="Cena netto [zł/km]"
                                    />

                                    <TextInput
                                        id="price"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.price"
                                        step="0.01"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.price"
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="tax"
                                        value="Podatek VAT [%]"
                                    />

                                    <TextInput
                                        id="tax"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.tax"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.tax"
                                    />
                                </div>
                            </div>
                            <PrimaryButton
                                class="ms-4 mt-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Zapisz
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
