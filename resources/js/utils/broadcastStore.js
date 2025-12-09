// src/utils/broadcastStore.js
/*export const bc = new BroadcastChannel('pinia_sync');

export function broadcastStoreChange(store) {
  bc.postMessage({ id: store.$id, state: store.$state });
}

export function listenStoreChanges(pinia) {
  bc.onmessage = (event) => {
    const { id, state } = event.data;
    const store = pinia._s.get(id);
    if (store) {
      store.$patch(state);
    }
  };
}*/
