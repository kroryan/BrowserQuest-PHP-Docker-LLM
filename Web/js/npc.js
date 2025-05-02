define(['character', 'i18n'], function(Character, i18n) {

    var Npc = Character.extend({
        init: function(id, kind) {
            this._super(id, kind, 1);
            this.itemKind = Types.getKindAsString(this.kind);
            this.talkIndex = 0;
            this.dialogs = i18n.get("npcs." + this.itemKind + ".dialogs");
            this.talkCount = this.dialogs ? this.dialogs.length : 0;
        },
    
        talk: function() {
            var msg = null;
            
            if(!this.dialogs || this.talkCount === 0) {
                return null;
            }
            
            if(this.talkIndex >= this.talkCount) {
                this.talkIndex = 0;
            }
            
            msg = this.dialogs[this.talkIndex];
            this.talkIndex += 1;
            
            return msg;
        }
    });
    
    return Npc;
});