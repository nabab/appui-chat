<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-list :source="source.users">
    <div class="bbn-w-100 bbn-spadded"
         style="overflow: auto"
         slot="item"
         slot-scope="user">
      <bbn-initial :user-id="user.id"
                   :user-name="user.name"
                   style="vertical-align: middle"
                   ></bbn-initial>
      <span class="bbn-large bbn-p"
            @click="testa(user.id)"
            v-text="user.name">
      </span>
    </div>
  </bbn-list>
</div>