<template>
    <div class="bg-white rounded-lg shadow p-4">
        <table
            class="table-auto w-full border-separate border-spacing-0 rounded-lg border border-blue-600"
        >
            <thead>
                <tr>
                    <th class="w-[30%] border border-gray-300 px-4 py-2">
                        Nome
                    </th>
                    <th class="w-[30%] border border-gray-300 px-4 py-2">
                        Data Nascimento
                    </th>
                    <th class="w-[30%] border border-gray-300 px-4 py-2">
                        Numero CNH
                    </th>
                    <th
                        class="w-[20%] border border-gray-300 px-2 py-2 whitespace-nowrap"
                    >
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="motorista in motoristas.data"
                    :key="motorista.id"
                    class="hover:bg-gray-100"
                >
                    <td
                        class="w-[30%] border text-center border-gray-300 px-4 py-2"
                    >
                        <template v-if="editandoId === motorista.id">
                            <InputField
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
                            <a 
                                @click.prevent="$inertia.visit(route('motoristas.show', motorista.id))"
                                class="hover:underline cursor-pointer"
                            >
                                {{ motorista.nome }}
                            </a>
                        </template>
                    </td>
                    <td
                        class="w-[30%] border text-center border-gray-300 px-4 py-2"
                    >
                        <template v-if="editandoId === motorista.id">
                            <InputField
                                type="date"
                                v-model="editarMotorista.data_nascimento"
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
                            {{ motorista.data_nascimento }}
                        </template>
                    </td>
                    <td
                        class="w-[30%] border text-center border-gray-300 px-4 py-2"
                    >
                        <template v-if="editandoId === motorista.id">
                            <InputField
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
                            {{ motorista.cnh }}
                        </template>
                    </td>
                    <td
                        class="w-[20%] border border-gray-300 px-2 py-2 whitespace-nowrap"
                    >
                        <div class="flex justify-center gap-2">
                            <template v-if="editandoId === motorista.id">
                                <SalvarButton
                                    @save="mostrarModalSalvar = true"
                                    :disabled="hasErrors"
                                />
                                <CancelButton @cancel="cancelarEdicao()" />
                            </template>
                            <template v-else>
                                <EditButton @editar="editar(motorista)" />
                                <DeleteButton @delete="excluir(motorista.id)" />
                            </template>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex justify-center gap-4">
            <button
                :disabled="motoristas.currentPage <= 1"
                @click="mudarPagina(motoristas.currentPage - 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowLeft></ArrowLeft>
            </button>

            <button
                :disabled="motoristas.currentPage >= motoristas.lastPage"
                @click="mudarPagina(motoristas.currentPage + 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowRight></ArrowRight>
            </button>
        </div>
        <div class="mt-4 text-center text-gray-500">
            Páginas {{ motoristas.currentPage }} de
            {{ motoristas.lastPage }}
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
import { ArrowLeft, ArrowRight } from "lucide-vue-next";
import DeleteButton from "../Buttons/DeleteButton.vue";
import EditButton from "../Buttons/EditButton.vue";
import { router } from "@inertiajs/vue3";
import { reactive, ref, computed } from "vue";
import CancelButton from "../Buttons/CancelButton.vue";
import SalvarButton from "../Buttons/SaveButton.vue";
import ConfirmModal from "../Modal/ConfirmModal.vue";
import InputField from "../Inputs/InputField.vue";

defineProps({
    motoristas: Object,
});

const mostrarModalSalvar = ref(false);

const mostrarModalDeletar = ref(false);
const motoristaParaExcluirId = ref(null);

function confirmarSalvar() {
    mostrarModalSalvar.value = false;
    salvarEdicao();
}

function excluir(id) {
    motoristaParaExcluirId.value = id;
    mostrarModalDeletar.value = true;
}

function confirmarDeletar() {
    mostrarModalDeletar.value = false;
    deletarMotorista(motoristaParaExcluirId.value);
}

function mudarPagina(novaPagina) {
    router.get(
        route("motoristas.index"),
        { page: novaPagina },
        {
            preserveState: true,
            replace: true,
        }
    );
}

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

function editar(motorista) {
    editandoId.value = motorista.id;
    editarMotorista.nome = motorista.nome;
    editarMotorista.data_nascimento = converterDataParaISO(
        motorista.data_nascimento
    );
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

function converterDataParaISO(dataBr) {
    if (!dataBr) return "";
    const partes = dataBr.split("/");
    if (partes.length !== 3) return "";
    const [dia, mes, ano] = partes;
    return `${ano}-${mes.padStart(2, "0")}-${dia.padStart(2, "0")}`;
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

function salvarEdicao() {
    validateNome();
    validateDataNascimento();
    validateCnh();

    if (hasErrors.value) {
        console.log("Validação falhou. Não é possível salvar.");
        return;
    }

    router.put(
        route("motoristas.update", editandoId.value),
        {
            nome: editarMotorista.nome,
            data_nascimento: editarMotorista.data_nascimento,
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
            },
        }
    );
}

function deletarMotorista(id) {
    router.delete(route("motoristas.destroy", id), {
        onSuccess: () => {
            motoristaParaExcluirId.value = null;
            editandoId.value = null;
        },
        onError: (e) => {
            console.error("Erro ao excluir:", e);
        },
    });
}
</script>
