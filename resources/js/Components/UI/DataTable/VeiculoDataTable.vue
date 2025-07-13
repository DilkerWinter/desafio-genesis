<template>
    <div class="bg-white rounded-lg shadow p-4">
        <table
            class="table-auto w-full border-separate border-spacing-0 rounded-lg border border-blue-600"
        >
            <thead>
                <tr>
                    <th class="w-[20%] border border-gray-300 px-4 py-2">
                        Modelo
                    </th>
                    <th class="w-[10%] border border-gray-300 px-4 py-2">
                        Ano
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Data Aquisição
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        KM Aquisição
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Renavam
                    </th>
                    <th class="w-[15%] border border-gray-300 px-4 py-2">
                        Placa
                    </th>
                    <th
                        class="w-[10%] border border-gray-300 px-4 py-2 whitespace-nowrap"
                    >
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="veiculo in veiculos.data"
                    :key="veiculo.id"
                    class="hover:bg-gray-100"
                >
                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="text"
                                v-model="editarVeiculo.modelo"
                                @blur="validateModelo"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.modelo"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.modelo }}
                            </p>
                        </template>
                        <template v-else>
                            <a 
                              @click.prevent="() => {
                                console.log('ID do veículo:', veiculo.id)
                                $inertia.visit(route('veiculos.show', veiculo.id))
                              }"
                              class="hover:underline cursor-pointer"
                            >
                              {{ veiculo.modelo }}
                            </a>

                        </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="number"
                                v-model.number="editarVeiculo.ano"
                                @blur="validateAno"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.ano"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.ano }}
                            </p>
                        </template>
                        <template v-else>
                            {{ veiculo.ano }}
                        </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="date"
                                v-model="editarVeiculo.data_aquisicao"
                                @blur="validateDataAquisicao"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.data_aquisicao"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.data_aquisicao }}
                            </p>
                        </template>
                        <template v-else>
                            {{ veiculo.data_aquisicao }}
                        </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="number"
                                v-model.number="editarVeiculo.km_aquisicao"
                                @blur="validateKmAquisicao"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.km_aquisicao"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.km_aquisicao }}
                            </p>
                        </template>
                        <template v-else>
                            {{ veiculo.km_aquisicao }}
                        </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="text"
                                v-model="editarVeiculo.renavam"
                                @blur="validateRenavam"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.renavam"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.renavam }}
                            </p>
                        </template>
                        <template v-else>
                            {{ veiculo.renavam }}
                        </template>
                    </td>

                    <td class="border text-center border-gray-300 px-4 py-2">
                        <template v-if="editandoId === veiculo.id">
                            <InputField
                                type="text"
                                v-model="editarVeiculo.placa"
                                @blur="validatePlaca"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.placa"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.placa }}
                            </p>
                        </template>
                        <template v-else>
                            {{ veiculo.placa }}
                        </template>
                    </td>

                    <td
                        class="border border-gray-300 px-2 py-2 whitespace-nowrap"
                    >
                        <div class="flex justify-center gap-2">
                            <template v-if="editandoId === veiculo.id">
                                <SalvarButton
                                    @save="mostrarModalSalvar = true"
                                    :disabled="hasErrors"
                                />
                                <CancelButton @cancel="cancelarEdicao()" />
                            </template>
                            <template v-else>
                                <EditButton @editar="editar(veiculo)" />
                                <DeleteButton @delete="excluir(veiculo.id)" />
                            </template>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 flex justify-center gap-4">
            <button
                :disabled="veiculos.currentPage <= 1"
                @click="mudarPagina(veiculos.currentPage - 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowLeft />
            </button>

            <button
                :disabled="veiculos.currentPage >= veiculos.lastPage"
                @click="mudarPagina(veiculos.currentPage + 1)"
                class="px-2 py-2 bg-blue-600 text-white rounded-md disabled:opacity-50"
            >
                <ArrowRight />
            </button>
        </div>
        <div class="mt-4 text-center text-gray-500">
            Páginas {{ veiculos.currentPage }} de {{ veiculos.lastPage }}
        </div>

        <ConfirmModal
            :show="mostrarModalSalvar"
            titulo="Deseja Salvar?"
            mensagem="Tem certeza que deseja salvar as alterações deste veículo?"
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
    </div>
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
    veiculos: Object,
});

const mostrarModalSalvar = ref(false);
const mostrarModalDeletar = ref(false);
const veiculoParaExcluirId = ref(null);

const editandoId = ref(null);
const editarVeiculo = reactive({
    modelo: "",
    ano: null,
    data_aquisicao: "",
    km_aquisicao: null,
    renavam: "",
    placa: "",
});

const errors = reactive({
    modelo: null,
    ano: null,
    data_aquisicao: null,
    km_aquisicao: null,
    renavam: null,
    placa: null,
});

const hasErrors = computed(() => {
    return Object.values(errors).some((error) => error !== null);
});

function editar(veiculo) {
    editandoId.value = veiculo.id;
    editarVeiculo.modelo = veiculo.modelo;
    editarVeiculo.ano = veiculo.ano;
    editarVeiculo.data_aquisicao = converterDataParaISO(veiculo.data_aquisicao);
    editarVeiculo.km_aquisicao = veiculo.km_aquisicao;
    editarVeiculo.renavam = veiculo.renavam;
    editarVeiculo.placa = veiculo.placa;

    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function cancelarEdicao() {
    editandoId.value = null;
    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function converterDataParaISO(dataBr) {
    if (!dataBr) return "";
    const partes = dataBr.split("/");
    if (partes.length !== 3) return "";
    const [dia, mes, ano] = partes;
    return `${ano}-${mes.padStart(2, "0")}-${dia.padStart(2, "0")}`;
}

function validateModelo() {
    if (!editarVeiculo.modelo || editarVeiculo.modelo.length < 2) {
        errors.modelo = "Modelo deve ter ao menos 2 caracteres.";
    } else {
        errors.modelo = null;
    }
}

function validateAno() {
    const year = editarVeiculo.ano;
    const currentYear = new Date().getFullYear();
    if (!year || year < 1900 || year > currentYear) {
        errors.ano = `Ano deve estar entre 1900 e ${currentYear}.`;
    } else {
        errors.ano = null;
    }
}

function validateDataAquisicao() {
    if (!editarVeiculo.data_aquisicao) {
        errors.data_aquisicao = "Data de aquisição é obrigatória.";
    } else {
        errors.data_aquisicao = null;
    }
}

function validateKmAquisicao() {
    if (editarVeiculo.km_aquisicao === null || editarVeiculo.km_aquisicao < 0) {
        errors.km_aquisicao = "KM na aquisição deve ser zero ou maior.";
    } else {
        errors.km_aquisicao = null;
    }
}

function validateRenavam() {
    const renavamRegex = /^\d{9,11}$/;
    if (!renavamRegex.test(editarVeiculo.renavam)) {
        errors.renavam = "Renavam deve conter entre 9 e 11 dígitos numéricos.";
    } else {
        errors.renavam = null;
    }
}

function validatePlaca() {
    const placaRegex = /^[A-Z]{3}[0-9][0-9A-Z][0-9]{2}$/;
    const placa = editarVeiculo.placa?.toUpperCase() || "";

    if (!placaRegex.test(placa)) {
        errors.placa = "Placa inválida. Formato esperado: ABC1D23";
        console.log(placa);
    } else {
        errors.placa = null;
    }
}

function salvarEdicao() {
    validateModelo();
    validateAno();
    validateDataAquisicao();
    validateKmAquisicao();
    validateRenavam();
    validatePlaca();

    if (hasErrors.value) {
        console.log("Validação falhou. Não é possível salvar.");
        return;
    }

    router.put(
        route("veiculos.update", editandoId.value),
        {
            modelo: editarVeiculo.modelo,
            ano: editarVeiculo.ano,
            data_aquisicao: editarVeiculo.data_aquisicao,
            km_aquisicao: editarVeiculo.km_aquisicao,
            renavam: editarVeiculo.renavam,
            placa: editarVeiculo.placa,
        },
        {
            onSuccess: () => {
                editandoId.value = null;
                Object.keys(errors).forEach((key) => (errors[key] = null));
            },
            onError: (e) => {
                console.error("Erro ao atualizar:", e);
            },
        }
    );
}

function excluir(id) {
    veiculoParaExcluirId.value = id;
    mostrarModalDeletar.value = true;
}

function confirmarSalvar() {
    mostrarModalSalvar.value = false;
    salvarEdicao();
}

function confirmarDeletar() {
    mostrarModalDeletar.value = false;
    deletarVeiculo(veiculoParaExcluirId.value);
}

function deletarVeiculo(id) {
    router.delete(route("veiculos.destroy", id), {
        onSuccess: () => {
            veiculoParaExcluirId.value = null;
            editandoId.value = null;
        },
        onError: (e) => {
            console.error("Erro ao excluir:", e);
        },
    });
}

function mudarPagina(novaPagina) {
    router.get(
        route("veiculos.index"),
        { page: novaPagina },
        {
            preserveState: true,
            replace: true,
        }
    );
}
</script>
