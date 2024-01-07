<script setup>
import html2pdf from "html2pdf.js";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    seller: Object,
    buyer: Object,
    data: Object,
});

let sellerData = usePage().props.auth.user.seller || {};

let seller = {
    company: sellerData ? sellerData.company || "" : "",
    street: sellerData.street || "",
    main_number: sellerData.main_number || "",
    local_number: sellerData.local_number || "",
    city: sellerData.city || "",
    postal_code_1: sellerData.postal_code_1 || "",
    postal_code_2: sellerData.postal_code_2 || "",
    nip: sellerData.nip || "",
    authorized_person: sellerData.authorized_person || "",
};

let buyerData = usePage().props.auth.user.buyer || {};

let buyer = {
    company: buyerData ? buyerData.company || "" : "",
    street: buyerData.street || "",
    main_number: buyerData.main_number || "",
    local_number: buyerData.local_number || "",
    city: buyerData.city || "",
    postal_code_1: buyerData.postal_code_1 || "",
    postal_code_2: buyerData.postal_code_2 || "",
    nip: buyerData.nip || "",
    authorized_person: buyerData.authorized_person || "",
};

let priceTaxData = usePage().props.auth.user.price || {};

let priceTax = {
    price: priceTaxData.price,
    tax: priceTaxData.tax,
};

const data = usePage().props.data;

const parts = data.deadline.split("-");
const formattedDeadline = `${parts[2]}.${parts[1]}.${parts[0]}`;

const nettoValue = Number(data.kilometers * priceTax.price).toFixed(2);
const vatValue = Number((nettoValue * priceTax.tax) / 100).toFixed(2);
const bruttoValue = (Number(nettoValue) + Number(vatValue)).toFixed(2);

const bruttoString = bruttoValue.toString();
const bruttoPart1 = bruttoString.split(".")[0];
const bruttoPart2 = bruttoString.split(".")[1];

const words = () => {
    var field_value_grosz = Number(bruttoPart2);

    var valueGrosz = parseInt(field_value_grosz);

    // przypisanie obiektu pola tekstowego do zmiennej
    var field_value = Number(bruttoPart1);
    // pobranie liczby
    var value = parseInt(field_value);

    var units = [
        "",
        " jeden",
        " dwa",
        " trzy",
        " cztery",
        " pięć",
        " sześć",
        " siedem",
        " osiem",
        " dziewięć",
    ];
    var teens = [
        "",
        " jedenaście",
        " dwanaście",
        " trzynaście",
        " czternaście",
        " piętnaście",
        " szesnaście",
        " siedemnaście",
        " osiemnaście",
        " dziewietnaście",
    ];
    var tens = [
        "",
        " dziesięć",
        " dwadzieścia",
        " trzydzieści",
        " czterdzieści",
        " pięćdziesiąt",
        " sześćdziesiąt",
        " siedemdziesiąt",
        " osiemdziesiąt",
        " dziewięćdziesiąt",
    ];
    var hundreds = [
        "",
        " sto",
        " dwieście",
        " trzysta",
        " czterysta",
        " pięćset",
        " sześćset",
        " siedemset",
        " osiemset",
        " dziewięćset",
    ];
    var groups = [
        ["", "", ""],
        [" tysiąc", " tysiące", " tysięcy"],
        [" milion", " miliony", " milionów"],
        [" miliard", " miliardy", " miliardów"],
        [" bilion", " biliony", " bilionów"],
        [" biliard", " biliardy", " biliardów"],
        [" trylion", " tryliony", " trylionów"],
    ];

    var groupsZłoty = [" złoty", " złote", " złotych"];

    var groupsGrosze = [" grosz", " grosze", " groszy"];

    // jezeli pole zawiera poprawna wartosc calkowita
    if (field_value == value.toString()) {
        var result = "";
        var resultGrosz = "";
        var złotyDodany = false;
        if (value == 0) result = "zero złoty";

        var g = 0;
        while (value > 0) {
            var s = Math.floor((value % 1000) / 100);
            var n = 0;
            var d = Math.floor((value % 100) / 10);
            var j = Math.floor(value % 10);

            if (d == 1 && j > 0) {
                n = j;
                d = 0;
                j = 0;
            }

            var k = 2;
            var z = 2;
            if (j == 1 && s + d + n == 0) k = 0;
            if (j == 2 || j == 3 || j == 4) k = 1;
            if (s + d + n + j > 0 && !złotyDodany) {
                result =
                    hundreds[s] +
                    tens[d] +
                    teens[n] +
                    units[j] +
                    groups[g][k] +
                    result +
                    groupsZłoty[k];

                złotyDodany = true; // Set the flag to indicate currency addition
            } else if (s + d + n + j > 0) {
                // If not the first iteration and the number part is not zero, continue adding without currency
                result =
                    hundreds[s] +
                    tens[d] +
                    teens[n] +
                    units[j] +
                    groups[g][k] +
                    result;
            }

            g++;
            value = Math.floor(value / 1000);
        }

        if (valueGrosz == 0) {
            resultGrosz = " zero groszy";
        } else {
            var n = 0;
            var d = Math.floor((valueGrosz % 100) / 10);
            var j = Math.floor(valueGrosz % 10);

            k = 2;
            if (d == 1 && j > 0) {
                n = j;
            }
            if (j == 1 && d + n == 0) {
                k = 0;
            }
            if (j == 2 || j == 3 || j == 4) {
                k = 1;
            }
            if (d + n + j > 0) {
                resultGrosz = tens[d] + teens[n] + units[j] + groupsGrosze[k];
            }

            valueGrosz = Math.floor(valueGrosz / 1000);
        }

        return result + resultGrosz;
    } else {
        alert("Podano nieprawidlowa wartosc!");
    }
};

const result = ref("");

onMounted(() => {
    result.value = words();
});

const pdfContent = ref(null);
const generatePDF = () => {
    const content = pdfContent.value;

    const options = {
        filename: data.invoice_number,
        html2canvas: { scale: 2 },
        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
    };

    // Generate PDF
    html2pdf().from(content).set(options).save();
};
</script>

<template>
    <div
        ref="pdfContent"
        class="flex justify-center py-16 px-12 flex-col text-sm"
    >
        <table class="">
            <thead>
                <tr class="pb-4">
                    <th
                        colspan="4"
                        rowspan="2"
                        class="border-x border-t border-black"
                    >
                        {{ data.invoice_number }}
                    </th>
                    <th
                        colspan="5"
                        class="text-center pb-3 border-y border-r border-black"
                    >
                        {{ data.last_day_of_month }} {{ seller.city }}
                        <p>Data i miejsce wystawienia dokumentu</p>
                    </th>
                </tr>
                <tr class="text-center">
                    <th colspan="5" class="pb-3 border-r border-black">
                        Data wykonania usługi {{ data.first_day_of_month }} -
                        {{ data.last_day_of_month }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td
                        colspan="4"
                        class="pb-2 px-2 border-y border-x border-black"
                    >
                        <p class="font-extrabold">Spzedawca</p>
                        <p class="font-extrabold">{{ seller.company }}</p>
                        <p>
                            {{ seller.street }} {{ seller.main_number }}
                            <span v-if="seller.local_number"
                                >/ {{ seller.local_number }}</span
                            >
                        </p>
                        <p>
                            {{ seller.postal_code_1 }} -
                            {{ seller.postal_code_2 }}
                            {{ seller.city }}
                        </p>
                        <p>Polska</p>
                        <p>NIP: {{ seller.nip }}</p>
                    </td>
                    <td
                        class="pb-2 px-2 border-y border-r border-black"
                        colspan="5"
                    >
                        <p class="font-extrabold">Nabywca</p>
                        <p class="font-extrabold">{{ buyer.company }}</p>
                        <p>
                            {{ buyer.street }} {{ buyer.main_number }}
                            <span v-if="buyer.local_number"
                                >/ {{ buyer.local_number }}</span
                            >
                        </p>
                        <p>
                            {{ buyer.postal_code_1 }} -
                            {{ buyer.postal_code_2 }}
                            {{ buyer.city }}
                        </p>
                        <p>Polska</p>
                        <p>NIP: {{ buyer.nip }}</p>
                    </td>
                </tr>
                <tr class="border-x border-black">
                    <td class="pb-3" colspan="9">
                        <div class="flex justify-around">
                            <p>Sposób płatności: {{ data.payment_method }}</p>
                            <p class="text-center">
                                Termin: {{ formattedDeadline }}
                            </p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td
                        class="pb-2 bg-gray-300 text-center border border-black"
                    >
                        LP
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Nazwa usługi
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        JM
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Ilość [km]
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Cena netto [zł/km]
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Wartość netto [zł]
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        VAT [%]
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Wartość VAT [zl]
                    </td>
                    <td
                        class="pb-2 bg-gray-300 text-center border-y border-r border-black"
                    >
                        Wartość brutto [zł]
                    </td>
                </tr>
                <tr>
                    <td class="pb-1 text-center border-b border-x border-black">
                        1
                    </td>
                    <td class="pb-2 text-center border-b border-r border-black">
                        {{ data.service_name }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        kilometr
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ data.kilometers }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ priceTax.price }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ nettoValue }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ priceTax.tax }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ vatValue }}
                    </td>
                    <td class="pb-1 text-center border-b border-r border-black">
                        {{ bruttoValue }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-10">
            <p class="font-extrabold">Razem do zapłaty: {{ bruttoValue }} zł</p>
            <p>Słownie: {{ result }}</p>
        </div>
        <div class="flex justify-between mt-20">
            <div class="flex flex-col items-center">
                <p>{{ buyer.authorized_person }}</p>
                <p class="mt-3">
                    ...............................................................
                </p>
                <p class="text-xs">(Osoba upoważniona do odbioru dokumentu)</p>
            </div>
            <div class="flex flex-col items-center">
                <p>{{ seller.authorized_person }}</p>
                <p class="mt-3">
                    ...............................................................
                </p>
                <p class="text-xs">
                    (Osoba upoważniona do wystawienia dokumentu)
                </p>
            </div>
        </div>

        <div class="mt-10" v-if="data.additional_info">
            <p>Dodatkowe uwagi</p>
            <p>{{ data.additional_info }}</p>
        </div>
    </div>

    <div class="flex justify-center mb-10">
        <PrimaryButton
            @click="generatePDF"
            :class="{ 'opacity-25': generatePDF.processing }"
        >
            Generuj fakturę
        </PrimaryButton>
    </div>
</template>
