<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Detalhes do Motorista
                </h1>

                <button
                    @click="$inertia.visit(route('motoristas.index'))"
                    class="bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-gray-700 transition"
                >
                    Lista de Motoristas
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-semibold">Informações Pessoais</h2>
                    <div class="space-x-2 flex">
                        <template v-if="editandoId === motorista.id">
                            <SaveButton
                                @click="mostrarModalSalvar = true"
                                :disabled="hasErrors"
                            >
                                Salvar
                            </SaveButton>
                        </template>
                        <template v-else>
                            <EditButton @editar="editar(motorista)" />
                        </template>

                        <DeleteButton @click="excluir(motorista.id)" />
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800"
                >
                    <div>
                        <p class="font-semibold">Nome</p>
                        <template v-if="editandoId === motorista.id">
                            <input
                                type="text"
                                v-model="editarMotorista.nome"
                                @blur="validateNome"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.nome"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.nome }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ motorista.nome }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Data de Nascimento</p>
                        <template v-if="editandoId === motorista.id">
                            <input
                                type="text"
                                v-model="editarMotorista.data_nascimento"
                                @input="mascararDataNascimento"
                                @blur="validateDataNascimento"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.data_nascimento"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.data_nascimento }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ formatarData(motorista.data_nascimento) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">CNH</p>
                        <template v-if="editandoId === motorista.id">
                            <input
                                type="text"
                                v-model="editarMotorista.cnh"
                                @blur="validateCnh"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.cnh"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.cnh }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ motorista.cnh }}</p>
                        </template>
                    </div>
                </div>
                <div
                    v-if="editandoId === motorista.id"
                    class="flex justify-end gap-2 mt-4"
                >
                    <CancelButton @click="cancelarEdicao()">
                        Cancelar
                    </CancelButton>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-semibold mb-4">
                    Histórico de Viagens
                </h2>

                <div
                    v-if="!motorista.viagens || motorista.viagens.length === 0"
                    class="text-gray-500"
                >
                    Nenhuma viagem registrada.
                </div>

                <div v-else class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <MotoristaViagemCard
                        v-for="(viagem, index) in motorista.viagens"
                        :key="index"
                        :viagem="viagem"
                    />
                </div>
            </div>
        </div>
    </div>
    <ConfirmModal
        :show="mostrarModalSalvar"
        titulo="Deseja Salvar?"
        mensagem="Tem certeza que deseja salvar as alterações deste motorista?"
        tipo="salvar"
        @confirmar="confirmarSalvar"
        @cancelar="mostrarModalSalvar = false"
    />
    <ConfirmModal
        :show="mostrarModalDeletar"
        titulo="Deseja Excluir?"
        mensagem="Esta ação não poderá ser desfeita."
        tipo="deletar"
        @confirmar="confirmarDeletar"
        @cancelar="mostrarModalDeletar = false"
    />
</template>

<script setup>
import MotoristaViagemCard from "@/Components/UI/Card/MotoristaViagemCard.vue";
import { defineProps, ref, reactive, computed } from "vue";
import { router } from "@inertiajs/vue3";
import ConfirmModal from "@/Components/UI/Modal/ConfirmModal.vue";
import DeleteButton from "@/Components/UI/Buttons/DeleteButton.vue";
import EditButton from "@/Components/UI/Buttons/EditButton.vue";
import SaveButton from "@/Components/UI/Buttons/SaveButton.vue";
import CancelButton from "@/Components/UI/Buttons/CancelButton.vue";

const props = defineProps({
    motorista: {
        type: Object,
        required: true,
    },
});

const mostrarModalSalvar = ref(false);
const mostrarModalDeletar = ref(false);
const motoristaParaExcluirId = ref(null);

const editandoId = ref(null);
const editarMotorista = reactive({
    nome: "",
    data_nascimento: "",
    cnh: "",
});

const errors = reactive({
    nome: null,
    data_nascimento: null,
    cnh: null,
});

const hasErrors = computed(() => {
    return Object.values(errors).some((error) => error !== null);
});

function formatarData(dataHoraStr) {
    if (!dataHoraStr) return "-";

    const data = new Date(dataHoraStr.replace(" ", "T"));
    const dia = data.getDate().toString().padStart(2, "0");
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const ano = data.getFullYear();

    return `${dia}/${mes}/${ano}`;
}

function converterDataParaISO(dataBr) {
    if (!dataBr) return "";
    if (dataBr.match(/^\d{4}-\d{2}-\d{2}$/)) {
        return dataBr;
    }
    const partes = dataBr.split("/");
    if (partes.length !== 3) return "";
    const [dia, mes, ano] = partes;
    return `${ano}-${mes.padStart(2, "0")}-${dia.padStart(2, "0")}`;
}

function editar(motorista) {
    editandoId.value = motorista.id;
    editarMotorista.nome = motorista.nome;
    editarMotorista.data_nascimento = formatarData(motorista.data_nascimento);
    editarMotorista.cnh = motorista.cnh;
    errors.nome = null;
    errors.data_nascimento = null;
    errors.cnh = null;
}

function cancelarEdicao() {
    editandoId.value = null;
    errors.nome = null;
    errors.data_nascimento = null;
    errors.cnh = null;
}

function validateNome() {
    if (editarMotorista.nome.length < 3) {
        errors.nome = "O nome deve ter mais de 3 caracteres.";
    } else {
        errors.nome = null;
    }
}

function validateDataNascimento() {
    const today = new Date();
    const birthDate = new Date(editarMotorista.data_nascimento);
    let age = today.getFullYear() - birthDate.getFullYear();
    const month = today.getMonth() - birthDate.getMonth();

    if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 18) {
        errors.data_nascimento = "O motorista deve ter mais de 18 anos.";
    } else {
        errors.data_nascimento = null;
    }
}

function validateCnh() {
    const cnhRegex = /^\d{11}$/;
    if (!cnhRegex.test(editarMotorista.cnh)) {
        errors.cnh = "O número da CNH deve ter 11 dígitos.";
    } else {
        errors.cnh = null;
    }
}

function mascararDataNascimento(event) {
    let valor = event.target.value.replace(/\D/g, "");

    if (valor.length > 8) valor = valor.slice(0, 8);

    if (valor.length > 4) {
        valor = valor.replace(/(\d{2})(\d{2})(\d{1,4})/, "$1/$2/$3");
    } else if (valor.length > 2) {
        valor = valor.replace(/(\d{2})(\d{1,2})/, "$1/$2");
    }

    editarMotorista.data_nascimento = valor;
}

function confirmarSalvar() {
    mostrarModalSalvar.value = false;
    salvarEdicao();
}

function salvarEdicao() {
    validateNome();
    validateDataNascimento();
    validateCnh();

    if (hasErrors.value) {
        console.log("Validação falhou. Não é possível salvar.");
        return;
    }

    const [dia, mes, ano] = editarMotorista.data_nascimento.split("/");
    const dataNascimento = `${ano}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;

    router.put(
        route("motoristas.update", editandoId.value),
        {
            nome: editarMotorista.nome,
            data_nascimento: dataNascimento,
            cnh: editarMotorista.cnh,
        },
        {
            onSuccess: () => {
                editandoId.value = null;
                errors.nome = null;
                errors.data_nascimento = null;
                errors.cnh = null;
            },
            onError: (e) => {
                console.error("Erro ao atualizar:", e);
                if (e && e.errors) {
                    for (const field in e.errors) {
                        if (errors.hasOwnProperty(field)) {
                            errors[field] = e.errors[field][0];
                        }
                    }
                }
            },
        }
    );
}

function excluir(id) {
    motoristaParaExcluirId.value = id;
    mostrarModalDeletar.value = true;
}

function confirmarDeletar() {
    mostrarModalDeletar.value = false;
    deletarMotorista(motoristaParaExcluirId.value);
}

function deletarMotorista(id) {
    router.delete(route("motoristas.destroy", id), {
        onSuccess: () => {
            motoristaParaExcluirId.value = null;
            editandoId.value = null;
            router.visit(route("motoristas.index"));
        },
        onError: (e) => {
            console.error("Erro ao excluir:", e);
        },
    });
}
</script>
