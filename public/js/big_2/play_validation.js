
//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid single that can be played, false otherwise
function validate_single(cards_played){
  return ((played.length == 0) || (cards_played[0] > played[0]));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid pair that can be played, false otherwise
function validate_pair(cards_played){
  valid_pair = (get_card_number(cards_played[0]) == get_card_number(cards_played[1]));

  return ((valid_pair) && ((played.length == 0) || (cards_played[1] > played[1])));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid three of a kind that can be played, false otherwise
function validate_three(cards_played){
  valid_three = ((get_card_number(cards_played[0]) == get_card_number(cards_played[1])) &&
                 (get_card_number(cards_played[0]) == get_card_number(cards_played[2])));

  return ((valid_three) && ((played.length == 0) || (cards_played[2] > played[2])));
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true is cards_played is a valid five card that can be played, false otherwise
function validate_five(cards_played){
  var type = get_five_card_type(cards_played);
  valid_five = true;
  if(played.length > 0){
    //ASSERT: not new round
    played_type = get_five_card_type(played);
    if(type < played_type){
      //ASSERT: cards_played invalid. type less than center cards
      valid_five = false;
    }
    else if(type == played_type){
      //ASSERT: type of cards played is the same as center cards
      if(type == 0){
        //ASSERT: straight played
        valid_five = (cards_played[4] > played[4]);
      }
      else if(type == 1){
        //ASSERT: flush played
        found = false;
        curr_card = 4;
        while((!found) && (curr_card> 0)){
          if(get_card_number(cards_played[curr_card]) != get_card_number(played[curr_card])){
            //ASSERT: found different number cards
            found = true;
            valid_five = (get_card_number(cards_played[curr_card]) > get_card_number(played[curr_card]));
          }
          else{
            curr_card -= 1;
          }
        }
        if(!found){
          //ASSERT: played_cards and played contain the same cards numericaly
          valid_five = (cards_played[4] > played[4]);
        }

      }
      else if((type == 2) || (type == 3)){
        //ASSERT: full house playted or 4 of a kind played
        valid_five = (cards_played[2] > played[2]);
      }
      else if(type == 4){
        //straight flush played
        valid_five = (cards_played[4] > played[4]);
      }
    }
  }
  else{
    //ASSERT: starting new round. Check that first play is a valid 5 card
    valid_type = (type != -1)
  }

  return valid_five;

}

//PRE: card is a nint from 1 to 52 representing a card in a deck of cards
//POST: returns an int from 0 to 3 representing the suite of card.
//      0=diamonds, 1=clubs, 2=hearts, 3=spades
function get_card_suit(card){
  var result = ((card - 1) % 4);
  return result;
}

//PRE: card is a nint from 1 to 52 representing a card in a deck of cards
//POST: returns a number from 0 to 12 representing card's numerical value
function get_card_number(card){
  var result = Math.floor((card - 1) / 4);
  return result;
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns an int from -1 to 4 representing the five cards hand it is
//      -1=invalid, 0=straight, 1=fluish, 2=full house, 3=4 of a kind, 5=straight flush
function get_five_card_type(cards_played){
  var result = -1;

  var numbers = [];
  var suits = [];

  for(var i = 0; i < cards_played.length; i++){
    numbers.push(get_card_number(cards_played[i]));
    suits.push(get_card_suit(cards_played[i]));
  }


  //straight test
  is_straight = true;
  var previous = numbers[0];
  var curr_card = 1
  while((is_straight) && (curr_card < cards_played.length)){

    is_straight = ((previous + 1) == numbers[curr_card]);
    previous = numbers[curr_card];
    curr_card += 1;
  }

  //flush test
  var is_flush = suits.every( (val, i, arr) => val === arr[0] );

  //full house test
  if(((numbers[0] == numbers[1]) && (numbers[0] == numbers[2]) && (numbers[3] == numbers[4])) || ((numbers[4] == numbers[3]) && (numbers[4] == numbers[2]) && (numbers[1] == numbers[0]))){
    result = 2
  }


  //four of a kind test
  if(((numbers[0] == numbers[1]) && (numbers[0] == numbers[2]) && (numbers[0] == numbers[3])) || ((numbers[4] == numbers[3]) && (numbers[4] == numbers[2]) && (numbers[4] == numbers[1]))){
    result = 3;
  }

  if((is_straight) && (is_flush)){
    //ASSERT: is stright flush
    result = 4
  }
  else if(is_straight){
    //ASSERT: is straight
    result = 0;
  }
  else if(is_flush){
    //ASSERT: is flush
    result = 1;
  }
  return result;

}

function sort_number(a, b){
  return a - b;
}

//PRE: cards_played is the array of ints representing the cards played
//POST: returns true if cards_played can be played with the current cards in the center
function validate_play(cards_played){
  //convert values to int and sort
  cards_played = cards_played.map(x=>+x);
  cards_played = cards_played.sort(sort_number);

  is_valid = true;

  if((played.length == 0) || (cards_played.length == played.length)){
    if(cards_played.length == 1){
      //ASSERT: single card played
      is_valid = validate_single(cards_played);
    }
    else if(cards_played.length == 2){
      //ASSERT: pair played
      is_valid = validate_pair(cards_played);
    }
    else if(cards_played.length == 3){
      //ASSERT: 3 of a kind played
      is_valid = validate_three(cards_played);
    }
    else if(cards_played.length == 5){
      //ASSERT: 5 card played
      is_valid = validate_five(cards_played);
    }
    else{
      //ASSERT: invalid number of cards played
      is_valid = false;
    }
  }
  else{
    is_valid = false;
  }

  return is_valid;
}
