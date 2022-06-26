<template>
  <v-container>
    <v-btn color="primary" @click="openNotes" block> Notes </v-btn>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card max-width="600" >
          <v-card-title class="blue-grey white--text ">
            <span class="text-h6">Logs</span>
            <v-spacer></v-spacer>
            <v-btn light depressed @click="addNote">
              Add Note
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn dark depressed outlined @click="closeNote">
              Cancel
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-timeline dense>
              <v-timeline-item small fill-dot v-for="note in allNotes" :key="note.id">
                <v-row class="pt-1">
                  <v-col cols="3">
                    <strong>{{ deduceDate(note.created_at) }}</strong>
                  </v-col>
                  <v-col>
                    <strong>{{ note.note_author }}</strong>
                    <div class="text-caption">
                      {{ note.note_body }}
                    </div>
                  </v-col>
                </v-row>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
      </v-dialog>
      <v-dialog v-model="newNoteDialog" persistent max-width="400px">
        <v-card>
          <v-card-title> New Note </v-card-title>
          <v-card-text>
            <v-container fluid>
              <v-textarea filled label="Keep it short and onpoint" rows="3" row-height="20" :rules="noteRules" shaped
                v-model="note.note_body"></v-textarea>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer> </v-spacer>
            <v-icon right color="green" @click="saveNote">mdi-check-bold</v-icon>
            <v-icon right color="red" @click="discardNote">mdi-close-thick</v-icon>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      noteRules: [(v) => v.length <= 100 || "Max 100 characters"],
      formRules: [(v) => !!v || "Required"],
      dialog: false,
      newNoteDialog: false,
      allNotes: [],
      note: {
        note_id: "",
        ticket_id: "",
        note_body: "",
        note_type: "message",
        note_author: "",
      },

      months: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"],
    };
  },

  components: {},

  methods: {

    openNotes() {
      this.allNotes= null;
      this.note.ticket_id = this.$store.state.ticket.selected.id_no;
      this.loadAllNotes();
      this.dialog = true;
    },
    closeNote() {
      this.dialog = false;
    },
    addNote() {
      this.newNoteDialog = true;
    },

    saveNote() {
      console.log("Saving note!");

      axios
        .post("api/notes/store", { note: this.note })
        .then((response) => {
          console.log(response.data);
          if (response.status == 201) {
            this.loadAllNotes();
            this.discardNote();

          }
        })
        .catch((err) => { });
    },
    discardNote() {
      console.log("Discard note");
      this.note.note_body = "";
      this.newNoteDialog = false;
    },
    loadAllNotes() {
      axios
        .get("api/notes/" + this.$store.state.ticket.selected.id_no)
        .then((response) => {

          this.allNotes = response.data;
          console.log(this.$store.state.ticket.selected.id_no);
          console.log(this.allNotes);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deduceDate(fromdate) {

      let formattedDate = new Date(fromdate);
      let month = this.months[formattedDate.getMonth()];
      let day = formattedDate.getDate();

      return day + " " + month;

    }
  },
  computed: {

  },
  created() {
    this.note.note_author = this.$store.state.user.name;
    // this.note.ticket_id = this.$store.state.ticket.selected.id_no;
    // this.loadAllNotes();

  },
};
</script>

<style>
.nav_column {
  margin-top: 5;
}



/* .v-card {
  display: flex !important;
  flex-direction: column;
  
}

.v-dialog{
 overflow: hidden !important;
}
.v-card-text {
  flex-grow: 1;
  overflow: auto;
} */
</style>