<template>
    <div class="relative bg-white rounded-lg shadow p-4 border border-blue-600">
        <button
            @click.prevent="$inertia.visit(route('viagens.show', viagem.id))"
            class="absolute top-4 right-4 text-gray-600 hover:text-blue-600 transition"
        >
            <ExternalLink class="w-5 h-5" />
        </button>
        <p>
            <strong>Motoristas:</strong>
            <template v-if="viagem.motoristas && viagem.motoristas.length > 0">
                <ul class=" list-inside">
                    <li
                        v-for="motorista in viagem.motoristas"
                        :key="motorista.id"
                    >
                        <a
                            @click.prevent="
                                $inertia.visit(
                                    route('motoristas.show', motorista.id)
                                )
                            "
                            class="hover:underline cursor-pointer"
                        >
                            {{ motorista.nome }}
                        </a>
                    </li>
                </ul>
            </template>
            <template v-else> Não informado </template>
        </p>

        <p>
            <strong>Quilometragem Inicial:</strong>
            {{ viagem.km_inicial }} km
        </p>
        <p>
            <strong>Quilometragem Final:</strong>
            {{ viagem.km_final }} km
        </p>

        <p>
            <strong>Início:</strong>
            {{ formatarData(viagem.data_hora_inicial) }}
        </p>
        <p>
            <strong>Fim:</strong>
            {{ formatarData(viagem.data_hora_final) }}
        </p>

        <p v-if="viagem.observacoes">
            <strong>Observações:</strong>
            {{ viagem.observacoes }}
        </p>
    </div>
</template>

<script setup>
import { ExternalLink } from "lucide-vue-next";
import { defineProps } from "vue";

const props = defineProps({
    viagem: {
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
