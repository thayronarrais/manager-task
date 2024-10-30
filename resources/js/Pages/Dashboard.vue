<!-- resources/js/Pages/Boards.vue -->

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { router, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const props = defineProps({
  boards: {
    type: Array,
    default: () => [],
  },
});


const form = useForm({
    name: '',
});


const showModal = ref(false);


function openBoard(boardId) {
  router.visit(`/boards/${boardId}`, { preserveScroll: true });
}

function createBoard() {
  if (form.name.trim()) {
    form.post('/boards', {
      onSuccess: () => {
        form.reset('name');
        showModal.value = false;
      },
    });
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Meus Quadros" />
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Main Content -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <div class="flex items-center mb-6">
            <h1 class="text-2xl font-bold flex-1">Meus Quadros</h1>
            <button @click="showModal = true" class="bg-blue-600 text-white px-4 py-2 rounded">
              + Criar Novo Quadro
            </button>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Board Card -->
            <div
              v-for="(board) in boards"
              :key="board.id"
              @click="openBoard(board.slug)"
              class="bg-gray-100 rounded-lg shadow cursor-pointer hover:shadow-lg transition-shadow"
            >
              <div class="p-6">
                <h2 class="text-xl font-bold mb-2">{{ board.name }}</h2>
                <p class="text-gray-600">{{ board.description }}</p>
              </div>
            </div>

            <!-- Botão para criar novo board dentro do grid -->
            <div
              @click="showModal = true"
              class="flex items-center justify-center bg-gray-200 rounded-lg cursor-pointer hover:bg-gray-300 transition-colors"
            >
              <span class="text-xl text-gray-600">+ Criar Novo Quadro</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para criação de novo quadro -->
    <div
      v-if="showModal"
      class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
    >
      <div class="bg-white p-6 rounded-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Criar Novo Quadro</h2>
        <input
          v-model="form.name"
          type="text"
          placeholder="Título do novo quadro"
          class="w-full p-2 border rounded mb-4"
        />
        <div class="flex justify-end space-x-2">
          <button @click="showModal = false" class="px-4 py-2 text-gray-600 rounded hover:bg-gray-100">
            Cancelar
          </button>
          <button @click="createBoard" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Criar
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
