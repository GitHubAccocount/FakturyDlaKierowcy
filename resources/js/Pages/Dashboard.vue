<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    firstDayOfMonth: String,
    lastDayOfMonth: String,
    lastDayOfMonthForInput: String,
    day10: String,
    currentMonth: String,
    currentYear: String,
});
const service_name = ref(
    `Usługa transportowa za okres ${props.firstDayOfMonth} do ${props.lastDayOfMonth}`
);

const invoice_number = ref(
    `Faktura Nr F/${props.currentMonth}/${props.currentYear}`
);

let priceTax = { price: 0, tax: 0 };

// get price and tax data
if (usePage().props.auth.user) {
    priceTax = usePage().props.auth.user.price;
}

const form = useForm({
    kilometers: "",
    invoice_number: invoice_number.value,
    service_name: service_name.value,
    first_day_of_month: props.firstDayOfMonth,
    last_day_of_month: props.lastDayOfMonth,
    last_day_of_month_for_input: props.lastDayOfMonthForInput,
    payment_method: "przelew",
    deadline: props.day10,
    additional_info: "",
});

const submit = () => {
    form.post(route("collectData"));
};
</script>

<template>
    <Head title="Generuj" />

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
                        <form @submit.prevent="submit">
                            <div>
                                <div class="mt-3">
                                    <InputLabel
                                        for="kilometers"
                                        value="Ilość kilometrów"
                                    />

                                    <TextInput
                                        id="kilometers"
                                        type="number"
                                        class="mt-1 block w-full"
                                        v-model="form.kilometers"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.kilometers"
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="invoice_number"
                                        value="Numer faktury"
                                    />

                                    <TextInput
                                        id="invoice_number"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="invoice_number"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.invoice_number"
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="service_name"
                                        value="Nazwa usługi"
                                    />

                                    <TextInput
                                        id="service_name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="service_name"
                                        required
                                    />

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.service_name"
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="date"
                                        value="Data wykonania usługi"
                                    />

                                    <input
                                        type="date"
                                        id="date"
                                        name="date"
                                        class="mt-1 block w-fit rounded-md"
                                        v-model="
                                            form.last_day_of_month_for_input
                                        "
                                        required
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="payment_method"
                                        value="Sposób płatności"
                                    />

                                    <select
                                        id="payment_method"
                                        v-model="form.payment_method"
                                        class="rounded-md"
                                    >
                                        <option value="przelew">przelew</option>
                                        <option value="gotówka">gotówka</option>
                                    </select>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.payment_method"
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="deadline"
                                        value="Termin płatności"
                                    />

                                    <input
                                        type="date"
                                        id="deadline"
                                        name="deadline"
                                        class="mt-1 block rounded-md w-fit"
                                        v-model="form.deadline"
                                        required
                                    />
                                </div>

                                <div class="mt-3">
                                    <InputLabel
                                        for="additional_info"
                                        value="Dodatkowe uwagi"
                                    />

                                    <textarea
                                        rows="4"
                                        cols="50"
                                        id="additional_info"
                                        name="additional_info"
                                        v-model="form.additional_info"
                                    ></textarea>

                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.additional_info"
                                    />
                                </div>
                            </div>
                            <PrimaryButton
                                class="ms-4 mt-3"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Generuj fakturę
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
