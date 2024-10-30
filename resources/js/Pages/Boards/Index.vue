<script setup>
import { ref } from 'vue';
import { router, Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    board: {
        type: Object,
        default: () => [],
    }
});

const isModalOpen = ref(false);
const isCardModalOpen = ref(false);
const isUpdateModalOpen = ref(false);

const selectedCardIndex = ref(null);
const selectedItem = ref(null);
const selectedCardId = ref(null);

const newItemText = ref('');
const newCardTitle = ref('');
const updateItemText = ref('');
const updateItemId = ref(null);

function openAddItemModal(index) {
    selectedCardIndex.value = index;
    newItemText.value = '';
    isModalOpen.value = true;
}

function addItem() {
    if (newItemText.value.trim() && selectedCardIndex.value !== null) {
        const card = props.board.cards[selectedCardIndex.value];
        router.post(route('item.store'), {
            board_id: props.board.id,
            card_id: card.id,
            name: newItemText.value
        }, {
            onSuccess: () => {
                isModalOpen.value = false;
                newItemText.value = '';
            },
            onError: (errors) => {
                console.error('Erro ao adicionar item:', errors);
            }
        });
    } else {
        console.error('Erro: Card selecionado não foi definido corretamente.');
    }
}

function openAddCardModal() {
    newCardTitle.value = '';
    isCardModalOpen.value = true;
}

function addCard() {
    if (newCardTitle.value.trim()) {
        router.post(route('card.store'), {
            board_id: props.board.id,
            name: newCardTitle.value
        }, {
            onSuccess: () => {
                isCardModalOpen.value = false;
                newCardTitle.value = '';
            },
            onError: (errors) => {
                console.error('Erro ao adicionar card:', errors);
            }
        });
    } else {
        console.error('Erro: Título do novo card não foi definido.');
    }
}

const isDeleteModalOpen = ref(false);

function openDeleteModal() {
    isDeleteModalOpen.value = true;
}

function closeDeleteModal() {
    isDeleteModalOpen.value = false;
}

function confirmDeleteBoard() {
    isDeleteModalOpen.value = false;
    deleteBoard();
}

function deleteBoard() {
    router.delete(route('boards.destroy', props.board.id), {
        onSuccess: () => {
            router.visit(route('boards.index'));
        },
        onError: (errors) => {
            console.error('Erro ao excluir o quadro:', errors);
        },
    });
}
function deleteItem(item_id) {
    router.delete(route('item.destroy', item_id), {
        onSuccess: () => {
            router.visit(route('boards.show', props.board.slug));
        },
        onError: (errors) => {
            console.error('Erro ao excluir o quadro:', errors);
        },
    });
}

function openUpdateItemModal(item, cardId) {
    selectedItem.value = item;
    selectedCardId.value = cardId;
    updateItemText.value = item.name;
    isUpdateModalOpen.value = true;
}


function updateItem() {
    if (updateItemText.value.trim() && selectedItem.value) {
        router.put(
            route('item.update', selectedItem.value.id),
            {
                board_id: props.board.id,
                card_id: selectedCardId.value,
                name: updateItemText.value,
            },
            {
                onSuccess: () => {
                    isUpdateModalOpen.value = false;
                    updateItemText.value = '';
                    selectedItem.value = null;
                    selectedCardId.value = null;
                },
                onError: (errors) => {
                    console.error('Erro ao atualizar item:', errors);
                },
            }
        );
    } else {
        console.error('Erro: Dados do item selecionado não estão completos.');
    }
}
</script>

<template>

    <Head :title="board.name" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="h-screen flex flex-col">
                    <main class="flex-1 overflow-auto p-4 bg-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-2xl font-bold">{{ board.name }}</h4>
                            <button @click="openDeleteModal" class="bg-red-600 text-white px-4 py-2 rounded">
                                Excluir Quadro
                            </button>
                        </div>

                        <div class="flex space-x-4 overflow-x-auto">
                            <div v-for="(list, index) in props.board.cards" :key="list.id"
                                class="w-64 bg-gray-200 rounded p-2 flex-shrink-0">
                                <h2 class="font-bold mb-2">{{ list.name }}</h2>
                                <div class="space-y-2">
                                    <div v-for="item in list.items" :key="item.id"
                                        class="bg-white p-2 rounded shadow cursor-pointer"
                                        @click="openUpdateItemModal(item, list.id)">
                                        {{ item.name }}
                                    </div>
                                </div>

                                <button @click="openAddItemModal(index)" class="mt-2 text-sm text-blue-600">
                                    + Adicionar item
                                </button>
                            </div>

                            <button @click="openAddCardModal"
                                class="w-64 bg-blue-600 rounded p-2 flex-shrink-0 text-center text-white font-bold">
                                + Adicionar novo card
                            </button>
                        </div>
                    </main>

                    <!-- Modal de confirmação de exclusão -->
                    <div v-if="isDeleteModalOpen" class="fixed inset-0 flex items-center justify-center z-50">

                        <div class="fixed inset-0 bg-gray-800 opacity-75"></div>


                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full z-50">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Excluir Quadro
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Tem certeza que deseja excluir este quadro? Esta ação não pode ser desfeita.
                                    </p>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button @click="confirmDeleteBoard" type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Excluir
                                </button>
                                <button @click="closeDeleteModal" type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para adicionar item -->
                    <div v-if="isModalOpen"
                        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-6 rounded shadow-lg w-96">
                            <h3 class="text-lg font-bold mb-4">Adicionar Novo Item</h3>
                            <input v-model="newItemText" type="text" placeholder="Título do item"
                                class="w-full p-2 mb-4 border border-gray-300 rounded" />
                            <div class="flex justify-between">
                                <button @click="addItem" class="bg-green-600 text-white px-4 py-2 rounded mr-2">
                                    Adicionar Item
                                </button>
                                <button @click="isModalOpen = false" class="text-gray-600">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para adicionar card -->
                    <div v-if="isCardModalOpen"
                        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-6 rounded shadow-lg w-96">
                            <h3 class="text-lg font-bold mb-4">Adicionar Novo Card</h3>
                            <input v-model="newCardTitle" type="text" placeholder="Título do card"
                                class="w-full p-2 mb-4 border border-gray-300 rounded" />
                            <div class="flex justify-between">
                                <button @click="addCard" class="bg-blue-600 text-white px-4 py-2 rounded">
                                    Adicionar Card
                                </button>
                                <button @click="isCardModalOpen = false" class="text-gray-600 mt-4">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para atualizar item -->
                    <div v-if="isUpdateModalOpen"
                        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center">
                        <div class="bg-white p-6 rounded shadow-lg w-96">
                            <h3 class="text-lg font-bold mb-4">Atualizar Item</h3>
                            <input v-model="updateItemText" type="text" placeholder="Título do item"
                                class="w-full p-2 mb-4 border border-gray-300 rounded" />
                            <div class="flex justify-between">
                                <button @click="updateItem" class="bg-green-600 text-white px-4 py-2 rounded mr-2">
                                    Atualizar Item
                                </button>
                                <button @click="deleteItem(selectedItem.id)" class="bg-red-600 text-white px-4 py-2 rounded mr-2">
                                    Excluir
                                </button>
                                <button @click="isUpdateModalOpen = false" class="text-gray-600">
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style></style>
