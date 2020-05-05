Echo.channel('table').listen('DealCards', (e) => {
  reset_round();
  set_hand(e.deck);
});
Echo.channel('table').listen('PlayCards', (e) => {
  //set center cards to played cards
  set_played_cards(e.cards_played);
  hide_passes();
  reset_turn_notifyer();
  set_turn_notifyer(parseInt(e.next_player));
  set_player_card_notification(e.current_player, e.cards_played);
  set_cards_played_notification(e.current_player);
});
Echo.channel('table').listen('Pass', (e) => {
  set_turn_notifyer(parseInt(e.next_player));
  show_pass(e.current_player);
  check_new_round(parseInt(e.current_player));
});
