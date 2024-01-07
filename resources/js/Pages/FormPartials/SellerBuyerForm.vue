<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    formOwner: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div>
        <div class="mt-3">
            <InputLabel for="company" value="Nazwa firmy" />
            <TextInput
                id="company"
                type="text"
                class="mt-1 block w-full"
                v-model="formOwner.company"
                required
            />

            <InputError class="mt-2" :message="formOwner.errors.company" />
        </div>

        <div class="mt-3">
            <InputLabel for="street" value="Ulica" />

            <TextInput
                id="street"
                type="text"
                class="mt-1 block w-full"
                v-model="formOwner.street"
                required
            />

            <InputError class="mt-2" :message="formOwner.errors.street" />
        </div>

        <div class="mt-3">
            <InputLabel for="main_number" value="Numer budynku" />

            <TextInput
                id="main_number"
                type="number"
                class="mt-1 block w-full"
                v-model.number="formOwner.main_number"
                required
            />

            <InputError class="mt-2" :message="formOwner.errors.main_number" />
        </div>

        <div class="mt-3">
            <InputLabel for="local_number" value="Numer lokalu" />

            <TextInput
                id="local_number"
                type="number"
                class="mt-1 block w-full"
                v-model.number="formOwner.local_number"
            />

            <InputError class="mt-2" :message="formOwner.errors.local_number" />
        </div>

        <div class="mt-3">
            <InputLabel for="city" value="Miejscowość" />

            <TextInput
                id="city"
                type="text"
                class="mt-1 block w-full"
                v-model="formOwner.city"
                required
            />

            <InputError class="mt-2" :message="formOwner.errors.city" />
        </div>

        <div class="w-1/3 inline-block mt-3">
            <InputLabel for="postal_code_1" value="Kod pocztowy" />

            <TextInput
                id="postal_code_1"
                type="number"
                class="mt-1 block w-full"
                v-model.number="formOwner.postal_code_1"
                required
            />

            <InputError
                class="mt-2"
                :message="formOwner.errors.postal_code_1"
            />
        </div>

        <div class="inline-block">-</div>

        <div class="w-1/3 inline-block">
            <TextInput
                id="postal_code_2"
                type="number"
                class="mt-1 block w-full"
                v-model.number="formOwner.postal_code_2"
                required
            />

            <InputError
                class="mt-2"
                :message="formOwner.errors.postal_code_2"
            />
        </div>

        <div class="mt-3">
            <InputLabel for="nip" value="Numer NIP" />

            <TextInput
                id="nip"
                type="number"
                class="mt-1 block w-full"
                v-model.number="formOwner.nip"
                required
            />

            <InputError class="mt-2" :message="formOwner.errors.nip" />
        </div>

        <div class="mt-3">
            <InputLabel for="authorized_person" value="Osoba upoważniona" />

            <TextInput
                id="authorized_person"
                type="text"
                class="mt-1 block w-full"
                v-model="formOwner.authorized_person"
                required
            />

            <InputError
                class="mt-2"
                :message="formOwner.errors.authorized_person"
            />
        </div>
    </div>
</template>
