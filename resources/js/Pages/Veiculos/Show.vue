<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Detalhes do Veículo
                </h1>

                <button
                    @click="$inertia.visit(route('veiculos.index'))"
                    class="bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-gray-700 transition"
                >
                    Lista de Veículos
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-semibold">
                        Informações do Veículo
                    </h2>
                    <div class="space-x-2 flex">
                        <template v-if="editandoId === veiculo.id">
                            <SaveButton
                                @click="mostrarModalSalvar = true"
                                :disabled="hasErrors"
                            >
                                Salvar
                            </SaveButton>
                        </template>
                        <template v-else>
                            <EditButton @editar="editar(veiculo)" />
                        </template>

                        <DeleteButton @click="excluir(veiculo.id)" />
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800"
                >
                    <div>
                        <p class="font-semibold">Modelo</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
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
                            <p>{{ veiculo.modelo }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Ano</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
                                type="number"
                                v-model="editarVeiculo.ano"
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
                            <p>{{ veiculo.ano }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Data de Aquisição</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
                                type="text"
                                v-model="editarVeiculo.data_aquisicao"
                                @input="mascararDataAquisicao"
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
                            <p>{{ formatarData(veiculo.data_aquisicao) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">KM na Aquisição</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
                                type="number"
                                v-model="editarVeiculo.km_aquisicao"
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
                            <p>{{ veiculo.km_aquisicao }} km</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Renavam</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
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
                            <p>{{ veiculo.renavam }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Placa</p>
                        <template v-if="editandoId === veiculo.id">
                            <input
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
                            <p>{{ veiculo.placa }}</p>
                        </template>
                    </div>
                </div>
                <div
                    v-if="editandoId === veiculo.id"
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
                    v-if="!veiculo.viagens || veiculo.viagens.length === 0"
                    class="text-gray-500"
                >
                    Nenhuma viagem registrada.
                </div>

                <div v-else class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    <VeiculoViagemCard
                        v-for="(viagem, index) in veiculo.viagens"
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
</template>

<script setup>
import VeiculoViagemCard from "@/Components/UI/Card/VeiculoViagemCard.vue";
import { defineProps, ref, reactive, computed } from "vue";
import { router } from "@inertiajs/vue3";
import ConfirmModal from "@/Components/UI/Modal/ConfirmModal.vue";
import DeleteButton from "@/Components/UI/Buttons/DeleteButton.vue";
import EditButton from "@/Components/UI/Buttons/EditButton.vue";
import SaveButton from "@/Components/UI/Buttons/SaveButton.vue";
import CancelButton from "@/Components/UI/Buttons/CancelButton.vue";

const props = defineProps({
    veiculo: {
        type: Object,
        required: true,
    },
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

function formatarData(dataStr) {
    if (!dataStr) return "-";
    const data = new Date(dataStr.replace(" ", "T"));
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

function editar(veiculo) {
    editandoId.value = veiculo.id;
    editarVeiculo.modelo = veiculo.modelo;
    editarVeiculo.ano = veiculo.ano;
    editarVeiculo.data_aquisicao = formatarData(veiculo.data_aquisicao);
    editarVeiculo.km_aquisicao = veiculo.km_aquisicao;
    editarVeiculo.renavam = veiculo.renavam;
    editarVeiculo.placa = veiculo.placa;
    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function cancelarEdicao() {
    editandoId.value = null;
    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function validateModelo() {
    if (!editarVeiculo.modelo || editarVeiculo.modelo.length < 2) {
        errors.modelo =
            "Modelo é obrigatório e deve ter ao menos 2 caracteres.";
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
        return;
    }
    const dateRegex = /^\d{2}\/\d{2}\/\d{4}$/;
    if (!dateRegex.test(editarVeiculo.data_aquisicao)) {
        errors.data_aquisicao = "Formato de data inválido. Use DD/MM/YYYY.";
        return;
    }

    const parts = editarVeiculo.data_aquisicao.split("/");
    const day = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10);
    const year = parseInt(parts[2], 10);

    const date = new Date(year, month - 1, day);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (
        isNaN(date.getTime()) ||
        date.getDate() !== day ||
        date.getMonth() + 1 !== month ||
        date.getFullYear() !== year ||
        date > today
    ) {
        errors.data_aquisicao = "Data de aquisição inválida ou futura.";
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
    const placaRegex = /^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/i;
    if (!placaRegex.test(editarVeiculo.placa)) {
        errors.placa = "Placa inválida. Formato esperado: ABC1D23";
    } else {
        errors.placa = null;
    }
}

function mascararDataAquisicao(event) {
    let valor = event.target.value.replace(/\D/g, "");

    if (valor.length > 8) valor = valor.slice(0, 8);

    if (valor.length > 4) {
        valor = valor.replace(/(\d{2})(\d{2})(\d{1,4})/, "$1/$2/$3");
    } else if (valor.length > 2) {
        valor = valor.replace(/(\d{2})(\d{1,2})/, "$1/$2");
    }

    editarVeiculo.data_aquisicao = valor;
}

function confirmarSalvar() {
    mostrarModalSalvar.value = false;
    salvarEdicao();
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
            data_aquisicao: converterDataParaISO(editarVeiculo.data_aquisicao),
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
    veiculoParaExcluirId.value = id;
    mostrarModalDeletar.value = true;
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
            router.visit(route("veiculos.index"));
        },
        onError: (e) => {
            console.error("Erro ao excluir:", e);
        },
    });
}
</script>
