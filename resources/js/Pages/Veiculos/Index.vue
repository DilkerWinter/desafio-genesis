<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Painel dos Veículos
                </h1>
                <button
                    @click="mostrarCadastro = true"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-blue-700 transition"
                >
                    Cadastrar novo veículo
                </button>
            </div>
            <div>
                <VeiculoDataTable :veiculos="veiculos" />
            </div>
        </div>
    </div>

    <CadastroModal
        :show="mostrarCadastro"
        @close="mostrarCadastro = false"
        @save="cadastrarVeiculo"
    >
        <div>
            <p class="font-semibold">Modelo</p>
            <InputField
                v-model="cadastroForm.modelo"
                type="text"
                @blur="validateModelo"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.modelo" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.modelo }}
            </p>
        </div>

        <div>
            <p class="font-semibold">Ano</p>
            <InputField
                v-model="cadastroForm.ano"
                type="number"
                @blur="validateAno"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.ano" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.ano }}
            </p>
        </div>

        <div>
            <p class="font-semibold">Data de Aquisição</p>
            <InputField
                v-model="cadastroForm.data_aquisicao"
                type="date"
                @blur="validateDataAquisicao"
                class="border rounded px-3 py-2 w-full"
            />
            <p
                v-if="errorsCadastro.data_aquisicao"
                class="text-red-600 text-sm mt-1"
            >
                {{ errorsCadastro.data_aquisicao }}
            </p>
        </div>

        <div>
            <p class="font-semibold">KM na Aquisição</p>
            <InputField
                v-model="cadastroForm.km_aquisicao"
                type="number"
                @blur="validateKmAquisicao"
                class="border rounded px-3 py-2 w-full"
            />
            <p
                v-if="errorsCadastro.km_aquisicao"
                class="text-red-600 text-sm mt-1"
            >
                {{ errorsCadastro.km_aquisicao }}
            </p>
        </div>

        <div>
            <p class="font-semibold">Renavam</p>
            <InputField
                v-model="cadastroForm.renavam"
                type="text"
                @blur="validateRenavam"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.renavam" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.renavam }}
            </p>
        </div>

        <div>
            <p class="font-semibold">Placa</p>
            <InputField
                v-model="cadastroForm.placa"
                type="text"
                @blur="validatePlaca"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.placa" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.placa }}
            </p>
        </div>
    </CadastroModal>
</template>

<script setup>
import VeiculoDataTable from "@/Components/UI/DataTable/VeiculoDataTable.vue";
import InputField from "@/Components/UI/Inputs/InputField.vue";
import CadastroModal from "@/Components/UI/Modal/CadastroModal.vue";
import { router } from "@inertiajs/vue3";
import { ref, reactive } from "vue";

const mostrarCadastro = ref(false);

const cadastroForm = reactive({
    modelo: "",
    ano: null,
    data_aquisicao: "",
    km_aquisicao: null,
    renavam: "",
    placa: "",
});

const errorsCadastro = reactive({
    modelo: null,
    ano: null,
    data_aquisicao: null,
    km_aquisicao: null,
    renavam: null,
    placa: null,
});

function validateModelo() {
    if (!cadastroForm.modelo || cadastroForm.modelo.length < 2) {
        errorsCadastro.modelo =
            "Modelo é obrigatório e deve ter ao menos 2 caracteres.";
    } else {
        errorsCadastro.modelo = null;
    }
}

function validateAno() {
    const year = cadastroForm.ano;
    const currentYear = new Date().getFullYear();
    if (!year || year < 1900 || year > currentYear) {
        errorsCadastro.ano = `Ano deve estar entre 1900 e ${currentYear}.`;
    } else {
        errorsCadastro.ano = null;
    }
}

function validateDataAquisicao() {
    if (!cadastroForm.data_aquisicao) {
        errorsCadastro.data_aquisicao = "Data de aquisição é obrigatória.";
    } else {
        errorsCadastro.data_aquisicao = null;
    }
}

function validateKmAquisicao() {
    if (cadastroForm.km_aquisicao === null || cadastroForm.km_aquisicao < 0) {
        errorsCadastro.km_aquisicao = "KM na aquisição deve ser zero ou maior.";
    } else {
        errorsCadastro.km_aquisicao = null;
    }
}

function validateRenavam() {
    const renavamRegex = /^\d{9,11}$/;
    if (!renavamRegex.test(cadastroForm.renavam)) {
        errorsCadastro.renavam =
            "Renavam deve conter entre 9 e 11 dígitos numéricos.";
    } else {
        errorsCadastro.renavam = null;
    }
}

function validatePlaca() {
    const placaRegex = /^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/i;
    if (!placaRegex.test(cadastroForm.placa)) {
        errorsCadastro.placa = "Placa inválida. Formato esperado: ABC1D23";
    } else {
        errorsCadastro.placa = null;
    }
}

function cadastrarVeiculo() {
    validateModelo();
    validateAno();
    validateDataAquisicao();
    validateKmAquisicao();
    validateRenavam();
    validatePlaca();

    const hasErrors = Object.values(errorsCadastro).some((e) => e !== null);
    if (hasErrors) {
        return;
    }

    router.post(route("veiculos.store"), cadastroForm, {
        onError: (errors) => {
            errorsCadastro.modelo = errors.modelo || null;
            errorsCadastro.ano = errors.ano || null;
            errorsCadastro.data_aquisicao = errors.data_aquisicao || null;
            errorsCadastro.km_aquisicao = errors.km_aquisicao || null;
            errorsCadastro.renavam = errors.renavam || null;
            errorsCadastro.placa = errors.placa || null;
        },
        onSuccess: () => {
            cadastroForm.modelo = "";
            cadastroForm.ano = null;
            cadastroForm.data_aquisicao = "";
            cadastroForm.km_aquisicao = null;
            cadastroForm.renavam = "";
            cadastroForm.placa = "";
            mostrarCadastro.value = false;
        },
    });
}

defineProps({
    veiculos: {
        type: Object,
        required: true,
    },
});
</script>
