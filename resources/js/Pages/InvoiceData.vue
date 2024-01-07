<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import SellerBuyerForm from "@/Pages/FormPartials/SellerBuyerForm.vue";

const props = defineProps({
    seller: Object,
    buyer: Object,
    message: String,
});

console.log(props.message);

let seller = {
    company: "",
    street: "",
    main_number: "",
    local_number: "",
    city: "",
    postal_code_1: "",
    postal_code_2: "",
    nip: "",
    authorized_person: "",
};

// get seller data
if (usePage().props.auth.user) {
    seller = usePage().props.auth.user.seller;
}
// fill form with seller data
const formSeller = useForm({
    company: seller.company ? seller.company : "",
    street: seller.street ? seller.street : "",
    main_number: seller.main_number ? seller.main_number : "",
    local_number: seller.local_number ? seller.local_number : "",
    city: seller.city ? seller.city : "",
    postal_code_1: seller.postal_code_1 ? seller.postal_code_1 : "",
    postal_code_2: seller.postal_code_2 ? seller.postal_code_2 : "",
    nip: seller.nip ? seller.nip : "",
    authorized_person: seller.authorized_person ? seller.authorized_person : "",
});

let buyer = {
    company: "",
    street: "",
    main_number: "",
    local_number: "",
    city: "",
    postal_code_1: "",
    postal_code_2: "",
    nip: "",
    authorized_person: "",
};

// get buyer data
if (usePage().props.auth.user) {
    buyer = usePage().props.auth.user.buyer;
}
// fill form with buyer data
const formBuyer = useForm({
    company: buyer.company,
    street: buyer.street,
    main_number: buyer.main_number,
    local_number: buyer.local_number,
    city: buyer.city,
    postal_code_1: buyer.postal_code_1,
    postal_code_2: buyer.postal_code_2,
    nip: buyer.nip,
    authorized_person: buyer.authorized_person ? buyer.authorized_person : "",
});

//get price/tax data
let priceTax = { price: 0, tax: 0 };

// get price and tax data
if (usePage().props.auth.user) {
    priceTax = usePage().props.auth.user.price;
}

const form = useForm({
    price: priceTax.price,
    tax: priceTax.tax,
});
</script>

<template>
    <Head title="Dane" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    v-if="$page.props.flash.message"
                    class="mb-4 font-medium text-sm text-green-600"
                >
                    {{ $page.props.flash.message }}
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- START SELLER -->
                        <form
                            @submit.prevent="
                                formSeller.patch(route('seller.invoice.update'))
                            "
                        >
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

                        <!-- START BUYER -->
                        <form
                            @submit.prevent="
                                formBuyer.patch(route('buyer.invoice.update'))
                            "
                            class="border-t-2 border-stone-900 mt-5"
                        >
                            <h3 class="mb-3 mt-5 font-bold text-xl">Nabywca</h3>

                            <SellerBuyerForm :formOwner="formBuyer" />

                            <PrimaryButton
                                class="ms-4 mt-3"
                                :class="{ 'opacity-25': formSeller.processing }"
                                :disabled="formSeller.processing"
                            >
                                Zapisz
                            </PrimaryButton>
                        </form>
                        <!-- END BUYER -->

                        <!-- START PRICE/TAX -->

                        <form
                            @submit.prevent="
                                form.patch(route('tax.price.update'))
                            "
                            class="border-t-2 border-stone-900 mt-5"
                        >
                            <h3 class="mb-3 mt-5 font-bold text-xl">
                                Cena i podatek
                            </h3>

                            <div class="mt-3">
                                <InputLabel
                                    for="price"
                                    value="Cena netto [zł/km]"
                                />

                                <TextInput
                                    id="price"
                                    type="number"
                                    step="0.01"
                                    class="mt-1 block w-full"
                                    v-model="form.price"
                                    required
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.price"
                                />
                            </div>

                            <div class="mt-3">
                                <InputLabel for="tax" value="Podatek VAT [%]" />

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

                            <PrimaryButton
                                class="ms-4 mt-3"
                                :class="{ 'opacity-25': formSeller.processing }"
                                :disabled="formSeller.processing"
                            >
                                Zapisz
                            </PrimaryButton>
                        </form>
                        <!-- END PRICE/TAX -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
