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
                    Voltar
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-semibold mb-4">
                    Informações Pessoais
                </h2>

                <div
                    class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-gray-800"
                >
                    <div>
                        <p class="font-semibold">Nome</p>
                        <p>{{ motorista.nome }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">Data de Nascimento</p>
                        <p>{{ formatarData(motorista.data_nascimento) }}</p>
                    </div>
                    <div>
                        <p class="font-semibold">CNH</p>
                        <p>{{ motorista.cnh }}</p>
                    </div>
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
                    <ViagemCard
                        v-for="(viagem, index) in motorista.viagens"
                        :key="index"
                        :viagem="viagem"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ViagemCard from "@/Components/UI/Card/ViagemCard.vue";
import { defineProps } from "vue";

const props = defineProps({
    motorista: {
        type: Object,
        required: true,
    },
});

function formatarData(dataHoraStr) {
    if (!dataHoraStr) return "-";

    const data = new Date(dataHoraStr.replace(" ", "T"));
    const dia = data.getDate().toString().padStart(2, "0");
    const mes = (data.getMonth() + 1).toString().padStart(2, "0");
    const ano = data.getFullYear();

    return `${dia}/${mes}/${ano}`;
}
</script>
