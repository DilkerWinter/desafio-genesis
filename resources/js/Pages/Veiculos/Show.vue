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
                <h2 class="text-2xl font-semibold mb-4">
                    Informações do Veículo
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800">
                    <div>
                        <p class="font-semibold">Modelo</p>
                        <p>{{ veiculo.modelo }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Ano</p>
                        <p>{{ veiculo.ano }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Data de Aquisição</p>
                        <p>{{ formatarData(veiculo.data_aquisicao) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">KM na Aquisição</p>
                        <p>{{ veiculo.km_aquisicao }} km</p>
                    </div>
                    <div>
                        <p class="font-semibold">Renavam</p>
                        <p>{{ veiculo.renavam }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Placa</p>
                        <p>{{ veiculo.placa }}</p>
                    </div>
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
</template>

<script setup>
import VeiculoViagemCard from "@/Components/UI/Card/VeiculoViagemCard.vue";
import { defineProps } from "vue";

const props = defineProps({
    veiculo: {
        type: Object,
        required: true,
    },
});

function formatarData(dataStr) {
    if (!dataStr) return "-";
    const data = new Date(dataStr.replace(" ", "T"));
    const dia = data.getDate().toString().padStart(2, "0");
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const ano = data.getFullYear();
    return `${dia}/${mes}/${ano}`;
}
</script>
