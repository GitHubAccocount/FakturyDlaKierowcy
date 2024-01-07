<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import SellerBuyerForm from "./FormPartials/SellerBuyerForm.vue";

const props = defineProps({
    seller: Object,
    buyer: Object,
});

const formSeller = useForm({
    company: "",
    street: "",
    main_number: "",
    local_number: "",
    city: "",
    postal_code_1: "",
    postal_code_2: "",
    nip: "",
    authorized_person: "",
});

const submitSeller = () => {
    formSeller.post(route("seller.invoice.store"));
};
</script>

<template>
    <Head title="Dane" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div>
                            <p class="text-xl mb-6 font-bold">
                                Uzupełnij poniższe dane:
                            </p>
                        </div>

                        <!-- START SELLER -->
                        <form @submit.prevent="submitSeller">
                            <h3 class="mb-3 font-bold text-xl">Sprzedawca</h3>

                            <SellerBuyerForm :formOwner="formSeller" />

                            <PrimaryButton
                                class="ms-4 mt-3"
                                :class="{ 'opacity-25': formSeller.processing }"
                                :disabled="formSeller.processing"
                            >
                                Zapisz
                            </PrimaryButton>
                        </form>
                        <!-- END SELLER -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
