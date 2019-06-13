<!-- HTML Document -->

<div class="bbn-overlay">
  <bbn-splitter orientation="horizontal"
                :resizable="true">
    <bbn-pane :size="300" :scrollable="false">
      <div class="bbn-flex-height">
        <div class="bbn-w-100" style="height: 30px">
          <bbn-input class="bbn-lg"
                     :style="{
                             width: '100%',
                             fontWeight: 'bold',
                             color: users.length ? 'inherit' : 'red'
                             }"
                     v-model="currentFilter">
          </bbn-input>
        </div>
        <div class="bbn-flex-fill">
          <bbn-list v-if="!users.length && !currentFilter"
                		:source="users"
                    class="bbn-overlay">
            <div class="bbn-w-100 bbn-p"
                 style="overflow: auto"
                 slot="item"
                 slot-scope="user"
                 @click="chatTo([user.value])">
              <bbn-initial :user-id="user.value"
                           :key="user.value"
                           :user-name="user.text"
                           :radius="5"
              ></bbn-initial>
              <span class="bbn-large"
                    v-text="user.text">
              </span>
            </div>
          </bbn-list>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane>
      <bbn-list :source="messages"
                :styled="false">
        <template slot="item"
                  slot-scope="msg">
          <bbn-initial :user-id="msg.user"
                       :key="msg.time"
                       :user-name="userName(msg.user)"
                       :radius="5"
                       ></bbn-initial>
          <span class="bbn-large"
                v-text="user.text">
          </span>
        </template>
      </bbn-list>
    </bbn-pane>
  </bbn-splitter>
</div>