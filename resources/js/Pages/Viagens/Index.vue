<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 text-center sm:text-left p-4 bg-white rounded-lg shadow"
            >
                <h1 class="text-3xl font-semibold mb-4 sm:mb-0">
                    Painel de Viagens
                </h1>
                <button
                    @click="mostrarCadastro = true"
                    class="bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow hover:bg-blue-700 transition"
                >
                    Cadastrar nova viagem
                </button>
            </div>

            <div>
                <ViagemDataTable :viagens="viagens" />
            </div>
        </div>
    </div>

    <CadastroModal
        :show="mostrarCadastro"
        @close="mostrarCadastro = false"
        @save="salvarViagem"
    >
        <form @submit.prevent="salvarViagem" class="space-y-4">
            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Motorista</label
                >
                <InputChoose
                    v-model="form.motorista_id"
                    :options="motoristas"
                    placeholder="Selecione o motorista"
                    label-key="nome"
                    id-key="id"
                />
            </div>
            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Veiculo</label
                >
                <InputChoose
                    v-model="form.veiculo_id"
                    :options="veiculosFormatados"
                    placeholder="Selecione o Veiculo"
                    label-key="label"
                    id-key="id"
                />
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Kilometragem Inicial do Veiculo</label
                >
                <InputField
                    v-model="form.km_inicial"
                    type="number"
                    required
                    @blur="validarKmInicial"
                    class="w-full border rounded px-3 py-2"
                />
                <p v-if="errors.km_inicial" class="text-red-600 text-sm mt-1">
                    {{ errors.km_inicial }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Kilometragem Final do Veiculo</label
                >
                <InputField
                    v-model="form.km_final"
                    type="number"
                    @blur="validarKmFinal"
                    class="w-full border rounded px-3 py-2"
                />
                <p v-if="errors.km_final" class="text-red-600 text-sm mt-1">
                    {{ errors.km_final }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Data Inicial da Viagem</label
                >
                <InputField
                    v-model="form.data_inicial"
                    type="text"
                    required
                    maxlength="10"
                    placeholder="dd/mm/aaaa"
                    class="w-full border rounded px-3 py-2"
                    @input="mascararData('data_inicial')"
                    @blur="validarDataInicial"
                />
                <p v-if="errors.data_inicial" class="text-red-600 text-sm mt-1">
                    {{ errors.data_inicial }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Hora Inicial da Viagem</label
                >
                <InputField
                    v-model="form.hora_inicial"
                    type="text"
                    required
                    maxlength="5"
                    placeholder="hh:mm"
                    class="w-full border rounded px-3 py-2"
                    @input="mascararHora('hora_inicial')"
                    @blur="validarHoraInicial"
                />
                <p v-if="errors.hora_inicial" class="text-red-600 text-sm mt-1">
                    {{ errors.hora_inicial }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Data Final da Viagem</label
                >
                <InputField
                    v-model="form.data_final"
                    type="text"
                    maxlength="10"
                    placeholder="dd/mm/aaaa"
                    class="w-full border rounded px-3 py-2"
                    @input="mascararData('data_final')"
                    @blur="validarDataFinal"
                />
                <p v-if="errors.data_final" class="text-red-600 text-sm mt-1">
                    {{ errors.data_final }}
                </p>
            </div>

            <div>
                <label class="block mb-1 font-medium text-gray-700"
                    >Hora Final da Viagem</label
                >
                <InputField
                    v-model="form.hora_final"
                    type="text"
                    maxlength="5"
                    placeholder="hh:mm"
                    class="w-full border rounded px-3 py-2"
                    @input="mascararHora('hora_final')"
                    @blur="validarHoraFinal"
                />
                <p v-if="errors.hora_final" class="text-red-600 text-sm mt-1">
                    {{ errors.hora_final }}
                </p>
            </div>
        </form>
    </CadastroModal>
</template>

<script setup>
import { computed, ref } from "vue";
import ViagemDataTable from "@/Components/UI/DataTable/ViagemDataTable.vue";
import CadastroModal from "@/Components/UI/Modal/CadastroModal.vue";
import InputField from "@/Components/UI/Inputs/InputField.vue";
import InputChoose from "@/Components/UI/Inputs/InputChoose.vue";

const props = defineProps({
    viagens: {
        type: Object,
        required: true,
    },
    motoristas: {
        type: Object,
        required: true,
    },
    veiculos: {
        type: Object,
        required: true,
    },
});

const mostrarCadastro = ref(false);

const form = ref({
    motorista_id: null,
    veiculo_id: null,
    km_inicial: "",
    km_final: "",
    data_inicial: "",
    hora_inicial: "",
    data_final: "",
    hora_final: "",
});

const errors = ref({});

function validarMotorista() {
    if (!form.value.motorista_id || form.value.motorista_id === 0) {
        errors.value.motorista_id = "Selecione um motorista.";
        return false;
    } else {
        delete errors.value.motorista_id;
        return true;
    }
}

function validarVeiculo() {
    if (!form.value.veiculo_id || form.value.veiculo_id === 0) {
        errors.value.veiculo_id = "Selecione um veículo.";
        return false;
    } else {
        delete errors.value.veiculo_id;
        return true;
    }
}

function validarKmInicial() {
    const value = form.value.km_inicial;
    if (value === null || value === "" || isNaN(value)) {
        errors.value.km_inicial = "Informe a kilometragem inicial.";
    } else if (value < 0) {
        errors.value.km_inicial =
            "Kilometragem inicial deve ser maior ou igual a 0.";
    } else {
        delete errors.value.km_inicial;
    }
}

function validarKmFinal() {
    if (form.value.km_final === "" || form.value.km_final === null || isNaN(form.value.km_final)) {
        delete errors.value.km_final;
        return;
    }

    const inicial = parseInt(form.value.km_inicial);
    const final = parseInt(form.value.km_final);

    if (final <= inicial) {
        errors.value.km_final = "Kilometragem final deve ser maior que a inicial.";
    } else {
        delete errors.value.km_final;
    }
}


const regexData = /^\d{2}\/\d{2}\/\d{4}$/;
const regexHora = /^([0-1]\d|2[0-3]):([0-5]\d)$/;

function validarData(str) {
    if (!regexData.test(str)) return false;

    const [diaStr, mesStr, anoStr] = str.split('/');
    const dia = parseInt(diaStr, 10);
    const mes = parseInt(mesStr, 10);
    const ano = parseInt(anoStr, 10);

    const dateObj = new Date(ano, mes - 1, dia);

    return (
        dateObj.getFullYear() === ano &&
        dateObj.getMonth() === (mes - 1) &&
        dateObj.getDate() === dia
    );
}

function validarHora(str) {
    if (!regexHora.test(str)) return false;

    const [hh, mm] = str.split(':').map(Number);
    return hh >= 0 && hh <= 23 && mm >= 0 && mm <= 59;
}

function validarDataInicial() {
    if (!form.value.data_inicial || !validarData(form.value.data_inicial)) {
        errors.value.data_inicial = "Informe uma data inicial válida (dd/mm/aaaa).";
        return false;
    }

    delete errors.value.data_inicial;
    return true;
}

function validarHoraInicial() {
    if (!form.value.hora_inicial || !validarHora(form.value.hora_inicial)) {
        errors.value.hora_inicial = "Informe uma hora inicial válida (hh:mm).";
        return false;
    }

    delete errors.value.hora_inicial;
    return true;
}

function validarDataFinal() {
    if (form.value.hora_final && !form.value.data_final) {
        errors.value.data_final = "Informe a data final se a hora final estiver preenchida.";
        return false;
    }

    if (form.value.data_final && !validarData(form.value.data_final)) {
        errors.value.data_final = "Formato de data final inválido.";
        return false;
    }

    delete errors.value.data_final;
    return true;
}

function validarHoraFinal() {
    if (form.value.data_final && !form.value.hora_final) {
        errors.value.hora_final = "Informe a hora final se a data final estiver preenchida.";
        return false;
    }

    if (form.value.hora_final && !validarHora(form.value.hora_final)) {
        errors.value.hora_final = "Formato de hora final inválido.";
        return false;
    }

    if (form.value.data_final === form.value.data_inicial && form.value.hora_final && form.value.hora_inicial) {
        const [hIni, mIni] = form.value.hora_inicial.split(":").map(Number);
        const [hFin, mFin] = form.value.hora_final.split(":").map(Number);

        const minutosInicial = hIni * 60 + mIni;
        const minutosFinal = hFin * 60 + mFin;

        if (minutosFinal <= minutosInicial) {
            errors.value.hora_final = "Hora final deve ser maior que hora inicial na mesma data.";
            return false;
        }
    }

    delete errors.value.hora_final;
    return true;
}

function mascararData(campo) {
    let valor = form.value[campo].replace(/\D/g, "");

    if (valor.length > 8) valor = valor.slice(0, 8);

    if (valor.length >= 5) {
        form.value[campo] = `${valor.slice(0, 2)}/${valor.slice(
            2,
            4
        )}/${valor.slice(4, 8)}`;
    } else if (valor.length >= 3) {
        form.value[campo] = `${valor.slice(0, 2)}/${valor.slice(2, 4)}`;
    } else {
        form.value[campo] = valor;
    }
}

function mascararHora(campo) {
    let valor = form.value[campo].replace(/\D/g, "");

    if (valor.length > 4) valor = valor.slice(0, 4);

    if (valor.length >= 3) {
        form.value[campo] = `${valor.slice(0, 2)}:${valor.slice(2, 4)}`;
    } else {
        form.value[campo] = valor;
    }
}

const veiculosFormatados = computed(() =>
    props.veiculos.map((v) => ({
        ...v,
        label: `${v.modelo} - ${v.placa}`,
    }))
);

function salvarViagem() {
    validarMotorista();
    validarVeiculo();
    validarKmInicial();
    validarKmFinal();
    validarDataInicial();
    validarDataFinal();
    validarHoraInicial();
    validarHoraFinal();

     if (Object.keys(errors.value).length > 0) {
        return;
    }

    console.log("Salvando viagem:", form.value);
    mostrarCadastro.value = false;
    form.value = {
        motorista_id: "",
        data: "",
    };
}
</script>
