<template>
  <tr v-bind:id="`row${element.id}`">
    <td>{{ element.id}}</td>
    <td>{{ element.name}}</td>
    <td>{{ element.email}}</td>
    <td>
      <button
        class="small ui blue button"
        v-bind:title="`Clique para editar ${element.name}`"
        @click="edit(element.id)"
      >Editar</button>
      <button
        class="small ui red button"
        v-bind:title="`Clique para excluir ${element.name}`"
        @click="apagar(element)"
      >Apagar</button>
    </td>
  </tr>
</template>

<script>
export default {
  name: "ItemTable",
  props: ["element"],
  data() {
    return {};
  },
  methods: {
    edit(id) {
      this.$router.push({ name: "edit", params: { id: id } });
    },
    apagar(item) {
      var app = this;
      if (window.confirm(`Deseja apagar ${item.name}?`)) {
        app.$parent.isLoading = true;
        fetch(appBaseUrl + "/auth/delete/" + item.id)
          .then(response => response.json())
          .then(res => {
            app.$parent.isLoading = false;
            if (res.status === "success") {
              app.$parent.removeUser(item.id);
              document.querySelector(`#row${item.id}`).style.cssText =
                "display:none";
            }
          })
          .catch(err => {
            app.$parent.isLoading = false;
            console.error("falha ao apagar item:" + err);
          });
      }
    }
  }
};
</script>