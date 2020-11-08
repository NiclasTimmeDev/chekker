<template>
    <!-- 
    The view to create a new process.
    The user can give the process a name and
    assign tags. All other stuff will be done
    at /process/{id}/edit.
    -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <h1>Neuer Prozess</h1>
        </div>
        <div class="col-md-8 col-lg-7">
            <form>
                <!-- TITLE -->
                <div class="form-group">
                    <label for="title">Titel</label>
                    <input
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Der Titel Ihres neuen Prozesses..."
                    />
                </div>
                <!--  -->
                <input
                    type="submit"
                    value="Prozess erstellen"
                    class="btn btn-primary"
                    @click.prevent=""
                />
            </form>
        </div>
    </div>
</template>
