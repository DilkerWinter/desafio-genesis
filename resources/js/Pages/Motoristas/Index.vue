<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Painel dos Motoristas
                </h1>
                <button
                    @click="mostrarCadastro = true"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-blue-700 transition"
                >
                    Cadastrar novo motorista
                </button>
            </div>

            <div>
                <MotoristaDataTable :motoristas="motoristas" />
            </div>
        </div>
    </div>

    <CadastroModal
        :show="mostrarCadastro"
        @close="mostrarCadastro = false"
        @save="cadastrarMotorista"
    >
        <div>
            <p class="font-semibold">Nome</p>
            <InputField
                v-model="cadastroForm.nome"
                type="text"
                @blur="validateNomeCadastro"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.nome" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.nome }}
            </p>
        </div>

        <div>
            <p class="font-semibold">Data de Nascimento</p>
            <InputField
                v-model="cadastroForm.data_nascimento"
                type="date"
                @blur="validateDataNascimentoCadastro"
                class="border rounded px-3 py-2 w-full"
            />
            <p
                v-if="errorsCadastro.data_nascimento"
                class="text-red-600 text-sm mt-1"
            >
                {{ errorsCadastro.data_nascimento }}
            </p>
        </div>

        <div>
            <p class="font-semibold">CNH</p>
            <InputField
                v-model="cadastroForm.cnh"
                type="text"
                @blur="validateCnhCadastro"
                class="border rounded px-3 py-2 w-full"
            />
            <p v-if="errorsCadastro.cnh" class="text-red-600 text-sm mt-1">
                {{ errorsCadastro.cnh }}
            </p>
        </div>
    </CadastroModal>
</template>

<script setup>
import MotoristaDataTable from "@/Components/UI/DataTable/MotoristaDataTable.vue";
import InputField from "@/Components/UI/Inputs/InputField.vue";
import CadastroModal from "@/Components/UI/Modal/CadastroModal.vue";
import { router } from "@inertiajs/vue3";
import { ref, reactive } from "vue";

const mostrarCadastro = ref(false);

const cadastroForm = reactive({
    nome: "",
    data_nascimento: "",
    cnh: "",
});

const errorsCadastro = reactive({
    nome: null,
    data_nascimento: null,
    cnh: null,
});

function validateNomeCadastro() {
    if (!cadastroForm.nome || cadastroForm.nome.length < 3) {
        errorsCadastro.nome = "O nome deve ter mais de 3 caracteres.";
    } else {
        errorsCadastro.nome = null;
    }
}

function validateDataNascimentoCadastro() {
    if (!cadastroForm.data_nascimento) {
        errorsCadastro.data_nascimento = "Data de nascimento é obrigatória.";
        return;
    }
    const today = new Date();
    const birthDate = new Date(cadastroForm.data_nascimento);
    let age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth() - birthDate.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 18) {
        errorsCadastro.data_nascimento =
            "O motorista deve ter mais de 18 anos.";
    } else {
        errorsCadastro.data_nascimento = null;
    }
}

function validateCnhCadastro() {
    const cnhRegex = /^\d{11}$/;
    if (!cnhRegex.test(cadastroForm.cnh)) {
        errorsCadastro.cnh = "O número da CNH deve ter 11 dígitos.";
    } else {
        errorsCadastro.cnh = null;
    }
}

function cadastrarMotorista() {
    validateNomeCadastro();
    validateDataNascimentoCadastro();
    validateCnhCadastro();

    const hasErrors = Object.values(errorsCadastro).some((e) => e !== null);
    if (hasErrors) {
        return;
    }

    router.post(route("motoristas.store"), cadastroForm, {
        onError: (errors) => {
            errorsCadastro.nome = errors.nome || null;
            errorsCadastro.data_nascimento = errors.data_nascimento || null;
            errorsCadastro.cnh = errors.cnh || null;
        },
        onSuccess: () => {
            cadastroForm.nome = "";
            cadastroForm.data_nascimento = "";
            cadastroForm.cnh = "";
            mostrarCadastro.value = false;

        },
    });

}

defineProps({
    motoristas: {
        type: Object,
        required: true,
    },
});
</script>
