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
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="motorista in motoristas.data"
                    :key="motorista.id"
                    class="hover:bg-gray-100"
                >
                    <td class="w-[30%] border text-center border-gray-300 px-4 py-2">
                        <a 
                            @click.prevent="$inertia.visit(route('motoristas.show', motorista.id))"
                            class="hover:underline cursor-pointer"
                        >
                            {{ motorista.nome }}
                        </a>
                    </td>
                    <td class="w-[30%] border text-center border-gray-300 px-4 py-2">
                        {{ motorista.data_nascimento }}
                    </td>
                    <td class="w-[30%] border text-center border-gray-300 px-4 py-2">
                        {{ motorista.cnh }}
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
</template>

<script setup>
import { ArrowLeft, ArrowRight } from "lucide-vue-next";
import { router } from "@inertiajs/vue3";

defineProps({
    motoristas: Object,
});

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
</script>
