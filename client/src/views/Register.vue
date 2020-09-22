<template>
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-8 col-lg-5">
        <form>
          <!-- Email -->
          <div class="form-group">
            <label for="email">E-Mail-Adresse</label>
            <input
              type="text"
              class="form-control"
              name="email"
              v-model="user.email"
            />
          </div>

          <!-- Name -->
          <div class="form-group">
            <label for="Name">Name</label>
            <input
              name="name"
              type="text"
              class="form-control"
              v-model="user.name"
            />
          </div>

          <!-- Password -->
          <div class="form-group">
            <label for="password">Passwort</label>
            <input
              type="password"
              name="password"
              class="form-control"
              v-model="user.password"
            />
          </div>

          <!-- Repeat Password -->
          <div class="form-group">
            <label for="exampleInputPassword1">Passwort wiederholen</label>
            <input
              type="password"
              name="password_confirmation"
              class="form-control"
              v-model="user.password_confirmation"
            />
          </div>

          <!-- Stay logged in -->
          <div class="form-group form-check">
            <input
              type="checkbox"
              class="form-check-input"
              id="exampleCheck1"
            />
            <label class="form-check-label" for="exampleCheck1"
              >Eingeloggt bleiben</label
            >
          </div>
          <button @click.prevent="register" class="btn btn-primary">
            Register
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: "",
        name: "",
        password: "",
        password_confirmation: ""
      }
    };
  },
  methods: {
    async register() {
      await axios.get("/sanctum/csrf-cookie");
      const res = await axios.post("/login", {
        email: "maggie.will@example.org",
        password: "password"
      });
      await axios.get("/user");
    }
  }
};
</script>
