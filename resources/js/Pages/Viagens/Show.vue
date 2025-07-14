<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Detalhes da Viagem
                </h1>

                <button
                    @click="$inertia.visit(route('viagens.index'))"
                    class="bg-gray-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-gray-700 transition"
                >
                    Lista de Viagens
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-semibold">
                        Informações da Viagem
                    </h2>
                    <div class="space-x-2 flex">
                        <template v-if="editandoId === viagem.id">
                            <SaveButton
                                @click="mostrarModalSalvar = true"
                                :disabled="hasErrors"
                            >
                                Salvar
                            </SaveButton>
                        </template>
                        <template v-else>
                            <EditButton @editar="editar(viagem)" />
                        </template>

                        <DeleteButton @click="excluir(viagem.id)" />
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800"
                >
                    <div>
                        <p class="font-semibold">Motoristas</p>
                        <template v-if="editandoId === viagem.id">
                            <div class="space-y-2">
                                <div
                                    v-for="(
                                        id, index
                                    ) in editarViagem.motoristas"
                                    :key="index"
                                    class="flex items-center gap-2"
                                >
                                    <select
                                        v-model="editarViagem.motoristas[index]"
                                        class="w-full border rounded px-2 py-1"
                                    >
                                        <option :value="null">
                                            Não informado
                                        </option>
                                        <option
                                            v-for="motoristaOption in motoristasFiltrados(index)"
                                            :key="motoristaOption.id"
                                            :value="String(motoristaOption.id)"
                                        >
                                            {{ motoristaOption.nome }}
                                        </option>
                                    </select>
                                    <button
                                        v-if="
                                            editarViagem.motoristas.length > 1
                                        "
                                        type="button"
                                        @click="removerMotorista(index)"
                                        class="text-red-500 hover:underline"
                                    >
                                        Remover
                                    </button>
                                </div>
                                <button
                                    type="button"
                                    @click="adicionarMotorista"
                                    class="text-blue-500 hover:underline text-sm mt-1"
                                >
                                    + Adicionar outro motorista
                                </button>
                                <p
                                    v-if="errors.motoristas"
                                    class="text-red-500 text-sm"
                                >
                                    {{ errors.motoristas }}
                                </p>
                            </div>
                        </template>
                        <template v-else>
                            <div
                                v-if="
                                    viagem.motoristas &&
                                    viagem.motoristas.length
                                "
                            >
                                <ul class="list-inside">
                                    <li
                                        v-for="motorista in viagem.motoristas"
                                        :key="motorista.id"
                                    >
                                        <a
                                            @click.prevent="
                                                $inertia.visit(
                                                    route(
                                                        'motoristas.show',
                                                        motorista.id
                                                    )
                                                )
                                            "
                                            class="hover:underline cursor-pointer"
                                        >
                                            {{ motorista.nome }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <p v-else>não informado</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Veículo</p>
                        <template v-if="editandoId === viagem.id">
                            <select
                                v-model="editarViagem.veiculo_id"
                                @blur="validateVeiculo"
                                class="w-full border rounded px-2 py-1"
                            >
                                <option :value="null">Não informado</option>
                                <option
                                    v-for="veiculoOption in veiculosFormatados"
                                    :key="veiculoOption.id"
                                    :value="veiculoOption.id"
                                >
                                    {{ veiculoOption.label }}
                                </option>
                            </select>
                            <p
                                v-if="errors.veiculo_id"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.veiculo_id }}
                            </p>
                        </template>
                        <template v-else>
                            <a
                                v-if="viagem.veiculo"
                                @click.prevent="
                                    $inertia.visit(
                                        route(
                                            'veiculos.show',
                                            viagem.veiculo.id
                                        )
                                    )
                                "
                                class="hover:underline cursor-pointer"
                            >
                                {{ viagem.veiculo.modelo }} ({{
                                    viagem.veiculo.placa
                                }})
                            </a>
                            <p v-else>não informado</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">
                            Kilometragem do Veiculo Inicial
                        </p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="number"
                                v-model="editarViagem.km_inicial"
                                @blur="validateKmInicial"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.km_inicial"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.km_inicial }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ viagem.km_inicial }} km</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">
                            Kilometragem do Veiculo Final
                        </p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="number"
                                v-model="editarViagem.km_final"
                                @blur="validateKmFinal"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.km_final"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.km_final }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ viagem.km_final }} km</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Distância Total</p>
                        <template v-if="editandoId === viagem.id">
                            <p
                                class="w-full border rounded px-2 py-1 bg-gray-100"
                            >
                                {{ calcularDistanciaTotal() }} Km
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ viagem.distancia_total }} Km</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Data Inicial</p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="text"
                                v-model="editarViagem.data_inicial_input"
                                @input="mascararData('data_inicial_input')"
                                @blur="validateDataHoraInicial"
                                maxlength="10"
                                placeholder="dd/mm/aaaa"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.data_hora_inicial"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.data_hora_inicial }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ formatarData(viagem.data_hora_inicial) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Hora Inicial</p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="text"
                                v-model="editarViagem.hora_inicial_input"
                                @input="mascararHora('hora_inicial_input')"
                                @blur="validateDataHoraInicial"
                                maxlength="5"
                                placeholder="hh:mm"
                                class="w-full border rounded px-2 py-1"
                            />
                        </template>
                        <template v-else>
                            <p>{{ formatarHora(viagem.data_hora_inicial) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Data Final</p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="text"
                                v-model="editarViagem.data_final_input"
                                @input="mascararData('data_final_input')"
                                @blur="validateDataHoraFinal"
                                maxlength="10"
                                placeholder="dd/mm/aaaa"
                                class="w-full border rounded px-2 py-1"
                            />
                            <p
                                v-if="errors.data_hora_final"
                                class="text-red-500 text-sm mt-1"
                            >
                                {{ errors.data_hora_final }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ formatarData(viagem.data_hora_final) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Hora Final</p>
                        <template v-if="editandoId === viagem.id">
                            <input
                                type="text"
                                v-model="editarViagem.hora_final_input"
                                @input="mascararHora('hora_final_input')"
                                @blur="validateDataHoraFinal"
                                maxlength="5"
                                placeholder="hh:mm"
                                class="w-full border rounded px-2 py-1"
                            />
                        </template>
                        <template v-else>
                            <p>{{ formatarHora(viagem.data_hora_final) }}</p>
                        </template>
                    </div>
                    <div>
                        <p class="font-semibold">Duração Total</p>
                        <template v-if="editandoId === viagem.id">
                            <p
                                class="w-full border rounded px-2 py-1 bg-gray-100"
                            >
                                {{ calcularDuracaoTotal() }}
                            </p>
                        </template>
                        <template v-else>
                            <p>{{ viagem.duracao_total }}</p>
                        </template>
                    </div>
                </div>
                <div
                    v-if="editandoId === viagem.id"
                    class="flex justify-end gap-2 mt-4"
                >
                    <CancelButton @click="cancelarEdicao()">
                        Cancelar
                    </CancelButton>
                </div>
            </div>
        </div>
    </div>
    <ConfirmModal
        :show="mostrarModalSalvar"
        titulo="Deseja Salvar?"
        mensagem="Tem certeza que deseja salvar as alterações desta viagem?"
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
import { defineProps, ref, reactive, computed } from "vue";
import { router } from "@inertiajs/vue3";
import ConfirmModal from "@/Components/UI/Modal/ConfirmModal.vue";
import DeleteButton from "@/Components/UI/Buttons/DeleteButton.vue";
import EditButton from "@/Components/UI/Buttons/EditButton.vue";
import SaveButton from "@/Components/UI/Buttons/SaveButton.vue";
import CancelButton from "@/Components/UI/Buttons/CancelButton.vue";
import axios from "axios";

const props = defineProps({
    viagem: {
        type: Object,
        required: true,
    },
});

const motoristas = ref([]);
const veiculos = ref([]);

const mostrarModalSalvar = ref(false);
const mostrarModalDeletar = ref(false);
const viagemParaExcluirId = ref(null);

const editandoId = ref(null);
const editarViagem = reactive({
    motoristas: [],
    veiculo_id: null,
    km_inicial: null,
    km_final: null,
    data_inicial_input: "",
    hora_inicial_input: "",
    data_final_input: "",
    hora_final_input: "",
});

const errors = reactive({
    motorista_id: null,
    veiculo_id: null,
    km_inicial: null,
    km_final: null,
    data_hora_inicial: null,
    data_hora_final: null,
});

const hasErrors = computed(() => {
    return Object.values(errors).some((error) => error !== null);
});

const regexData = /^\d{2}\/\d{2}\/\d{4}$/;
const regexHora = /^([0-1]\d|2[0-3]):([0-5]\d)$/;

function formatarData(dataStr) {
    if (!dataStr) return "";
    const data = new Date(dataStr.replace(" ", "T"));
    const dia = data.getDate().toString().padStart(2, "0");
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}

function formatarHora(dataStr) {
    if (!dataStr) return "";
    const data = new Date(dataStr);
    const hora = data.getHours().toString().padStart(2, "0");
    const minuto = data.getMinutes().toString().padStart(2, "0");
    return `${hora}:${minuto}`;
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

function getFormattedDateTime(dateStr, timeStr) {
    if (!dateStr || !timeStr) return null;
    const isoDate = converterDataParaISO(dateStr);
    if (!isoDate) return null;
    return `${isoDate}T${timeStr}:00`;
}

function adicionarMotorista() {
    editarViagem.motoristas.push(null);
}

function removerMotorista(index) {
    editarViagem.motoristas.splice(index, 1);
}

function motoristasFiltrados(indiceAtual) {
  const selecionados = editarViagem.motoristas
    .filter((id, i) => id !== null && i !== indiceAtual)
    .map(id => Number(id));  

  return motoristas.value.filter(
    (motorista) => !selecionados.includes(motorista.id)
  );
}



async function editar(viagem) {
    try {
        const resMotoristas = await axios.get(route("motoristas.list"));
        const resVeiculos = await axios.get(route("veiculos.list"));

        motoristas.value = resMotoristas.data;
        veiculos.value = resVeiculos.data;
    } catch (error) {
        console.error("Erro ao carregar motoristas/veículos:", error);
    }
    editandoId.value = viagem.id;
    editarViagem.motoristas = viagem.motoristas?.map((m) => String(m.id)) || [
        null,
    ];
    editarViagem.veiculo_id = viagem.veiculo_id;

    editarViagem.km_inicial = viagem.km_inicial;
    editarViagem.km_final = viagem.km_final;

    editarViagem.data_inicial_input = formatarData(viagem.data_hora_inicial);
    editarViagem.hora_inicial_input = formatarHora(viagem.data_hora_inicial);

    editarViagem.data_final_input = formatarData(viagem.data_hora_final);
    editarViagem.hora_final_input = formatarHora(viagem.data_hora_final);

    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function cancelarEdicao() {
    editandoId.value = null;
    Object.keys(errors).forEach((key) => (errors[key] = null));
}

function validateMotoristas() {
    if (
        !editarViagem.motoristas.length ||
        editarViagem.motoristas.some((id) => !id)
    ) {
        errors.motoristas =
            "Todos os campos de motorista devem estar preenchidos.";
    } else {
        errors.motoristas = null;
    }
}

function validateVeiculo() {
    if (!editarViagem.veiculo_id) {
        errors.veiculo_id = "Veículo é obrigatório.";
    } else {
        errors.veiculo_id = null;
    }
}

function validateKmInicial() {
    const value = editarViagem.km_inicial;
    if (value === null || value === "" || isNaN(value)) {
        errors.km_inicial = "Informe a kilometragem inicial.";
    } else if (value < 0) {
        errors.km_inicial = "Kilometragem inicial deve ser maior ou igual a 0.";
    } else {
        errors.km_inicial = null;
    }
}

function validateKmFinal() {
    if (
        editarViagem.km_final === "" ||
        editarViagem.km_final === null ||
        isNaN(editarViagem.km_final)
    ) {
        errors.km_final = null;
        return;
    }

    const inicial = parseInt(editarViagem.km_inicial);
    const final = parseInt(editarViagem.km_final);

    if (final <= inicial) {
        errors.km_final = "Kilometragem final deve ser maior que a inicial.";
    } else {
        errors.km_final = null;
    }
}


function validarData(str) {
    if (!regexData.test(str)) return false;

    const [diaStr, mesStr, anoStr] = str.split("/");
    const dia = parseInt(diaStr, 10);
    const mes = parseInt(mesStr, 10);
    const ano = parseInt(anoStr, 10);

    const dateObj = new Date(ano, mes - 1, dia);

    return (
        dateObj.getFullYear() === ano &&
        dateObj.getMonth() === mes - 1 &&
        dateObj.getDate() === dia
    );
}

function validarHora(str) {
    if (!regexHora.test(str)) return false;

    const [hh, mm] = str.split(":").map(Number);
    return hh >= 0 && hh <= 23 && mm >= 0 && mm <= 59;
}

function validateDataHoraInicial() {
    if (
        !editarViagem.data_inicial_input ||
        !validarData(editarViagem.data_inicial_input)
    ) {
        errors.data_hora_inicial =
            "Informe uma data inicial válida (dd/mm/aaaa).";
        return;
    }

    if (
        !editarViagem.hora_inicial_input ||
        !validarHora(editarViagem.hora_inicial_input)
    ) {
        errors.data_hora_inicial = "Informe uma hora inicial válida (hh:mm).";
        return;
    }

    const initialDateTime = new Date(
        getFormattedDateTime(
            editarViagem.data_inicial_input,
            editarViagem.hora_inicial_input
        )
    );
    const now = new Date();
    now.setSeconds(0, 0);

    if (isNaN(initialDateTime.getTime())) {
        errors.data_hora_inicial = "Data e hora inicial inválidas.";
    } else if (initialDateTime > now) {
        errors.data_hora_inicial = "Data/Hora Inicial não pode ser futura.";
    } else {
        errors.data_hora_inicial = null;
    }

    validateDataHoraFinal();
}

function validateDataHoraFinal() {
    const hasDataFinal = !!editarViagem.data_final_input;
    const hasHoraFinal = !!editarViagem.hora_final_input;

    if (hasDataFinal && !hasHoraFinal) {
        errors.data_hora_final =
            "Informe a hora final se a data final estiver preenchida.";
        return;
    }
    if (!hasDataFinal && hasHoraFinal) {
        errors.data_hora_final =
            "Informe a data final se a hora final estiver preenchida.";
        return;
    }

    if (!hasDataFinal && !hasHoraFinal) {
        errors.data_hora_final = null;
        return;
    }

    if (!validarData(editarViagem.data_final_input)) {
        errors.data_hora_final = "Informe uma data final válida (dd/mm/aaaa).";
        return;
    }

    if (!validarHora(editarViagem.hora_final_input)) {
        errors.data_hora_final = "Informe uma hora final válida (hh:mm).";
        return;
    }

    const startDateTime = new Date(
        getFormattedDateTime(
            editarViagem.data_inicial_input,
            editarViagem.hora_inicial_input
        )
    );
    const endDateTime = new Date(
        getFormattedDateTime(
            editarViagem.data_final_input,
            editarViagem.hora_final_input
        )
    );

    if (isNaN(endDateTime.getTime())) {
        errors.data_hora_final = "Data e hora final inválidas.";
    } else if (endDateTime < startDateTime) {
        errors.data_hora_final =
            "Data/Hora Final não pode ser anterior à Data/Hora Inicial.";
    } else {
        errors.data_hora_final = null;
    }
}


function mascararData(campo) {
    let valor = editarViagem[campo].replace(/\D/g, "");

    if (valor.length > 8) valor = valor.slice(0, 8);

    if (valor.length >= 5) {
        editarViagem[campo] = `${valor.slice(0, 2)}/${valor.slice(
            2,
            4
        )}/${valor.slice(4, 8)}`;
    } else if (valor.length >= 3) {
        editarViagem[campo] = `${valor.slice(0, 2)}/${valor.slice(2, 4)}`;
    } else {
        editarViagem[campo] = valor;
    }
}

function mascararHora(campo) {
    let valor = editarViagem[campo].replace(/\D/g, "");

    if (valor.length > 4) valor = valor.slice(0, 4);

    if (valor.length >= 3) {
        editarViagem[campo] = `${valor.slice(0, 2)}:${valor.slice(2, 4)}`;
    } else {
        editarViagem[campo] = valor;
    }
}

const veiculosFormatados = computed(() =>
    veiculos.value.map((v) => ({
        ...v,
        label: `${v.modelo} - ${v.placa}`,
    }))
);

function calcularDistanciaTotal() {
    const kmInicial = parseFloat(editarViagem.km_inicial);
    const kmFinal = parseFloat(editarViagem.km_final);

    if (isNaN(kmInicial) || isNaN(kmFinal) || kmFinal < kmInicial) {
        return "0.00";
    }
    return (kmFinal - kmInicial).toFixed(2);
}

function calcularDuracaoTotal() {
    const startDateTime = new Date(
        getFormattedDateTime(
            editarViagem.data_inicial_input,
            editarViagem.hora_inicial_input
        )
    );
    const endDateTime = new Date(
        getFormattedDateTime(
            editarViagem.data_final_input,
            editarViagem.hora_final_input
        )
    );

    if (
        isNaN(startDateTime.getTime()) ||
        isNaN(endDateTime.getTime()) ||
        endDateTime < startDateTime
    ) {
        return "00h 00m";
    }

    const diffMs = endDateTime - startDateTime;
    const diffMinutes = Math.floor(diffMs / (1000 * 60));

    const hours = Math.floor(diffMinutes / 60);
    const minutes = diffMinutes % 60;

    return `${String(hours).padStart(2, "0")}h ${String(minutes).padStart(
        2,
        "0"
    )}m`;
}

function confirmarSalvar() {
    mostrarModalSalvar.value = false;
    salvarEdicao();
}

function salvarEdicao() {
    validateMotoristas();
    validateVeiculo();
    validateKmInicial();
    validateKmFinal();
    validateDataHoraInicial();
    validateDataHoraFinal();

    if (hasErrors.value) {
        console.log("Validação falhou. Não é possível salvar.");
        return;
    }

    router.put(
        route("viagens.update", editandoId.value),
        {
            motoristas: editarViagem.motoristas,
            veiculo_id: editarViagem.veiculo_id,
            km_inicial: editarViagem.km_inicial,
            km_final: editarViagem.km_final || null,
            data_hora_inicial: getFormattedDateTime(
                editarViagem.data_inicial_input,
                editarViagem.hora_inicial_input
            ),
            data_hora_final:
                editarViagem.data_final_input && editarViagem.hora_final_input
                    ? getFormattedDateTime(
                          editarViagem.data_final_input,
                          editarViagem.hora_final_input
                      )
                    : null,
            distancia_total: calcularDistanciaTotal(),
            duracao_total: calcularDuracaoTotal(),
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
                        if (
                            field.includes("data_hora_inicial") &&
                            errors.hasOwnProperty("data_hora_inicial")
                        ) {
                            errors.data_hora_inicial = e.errors[field][0];
                        } else if (
                            field.includes("data_hora_final") &&
                            errors.hasOwnProperty("data_hora_final")
                        ) {
                            errors.data_hora_final = e.errors[field][0];
                        } else if (errors.hasOwnProperty(field)) {
                            errors[field] = e.errors[field][0];
                        }
                    }
                }
            },
        }
    );
}

function excluir(id) {
    viagemParaExcluirId.value = id;
    mostrarModalDeletar.value = true;
}

function confirmarDeletar() {
    mostrarModalDeletar.value = false;
    deletarViagem(viagemParaExcluirId.value);
}

function deletarViagem(id) {
    router.delete(route("viagens.destroy", id), {
        onSuccess: () => {
            viagemParaExcluirId.value = null;
            editandoId.value = null;
            router.visit(route("viagens.index"));
        },
        onError: (e) => {
            console.error("Erro ao excluir:", e);
        },
    });
}
</script>
