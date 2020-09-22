<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-dark">
    <router-link class="navbar-brand" to="/">Chekker.io</router-link>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span
        class="navbar-toggler-icon"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
      ></span>
    </button>

    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <router-link class="nav-link" to="/login">Login</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/register">Register</router-link>
        </li>
      </ul>
      <router-link
        to="/beta-testing"
        class="btn btn-outline-primary my-2 my-sm-0"
        type="submit"
      >
        Jetzt testen
      </router-link>
    </div>
  </nav>
</template>

<style lang="scss" scoped>
nav {
  z-index: 100;
}
</style>
