# jsonimport
Import from URL

Build using: Symfony framework.

Task:
Kreirati funkcionalnost za import podataka svetskog prvenstva u fudbalu 2018. god.
Sa sledeća dva linka:
http://worldcup.sfg.io/matches i http://worldcup.sfg.io/teams/

Obratiti pažnju na to da se import može izvršavati više puta, tako da je neophodno uraditi funkcionalnost i za import i za eventualni update podataka.

Na osnovu importovanih podataka, kreirati funkcionalnost koja će vratiti json sa sledećim podacima i u istom formatu: http://worldcup.sfg.io/matches ali poređanih po temperaturi (najtoplije ka najhladnije)

Na osnovu importovanih podataka, kreirati funkcionalnost koja će vratiti json sa sledećim podacima i u istom formatu: http://worldcup.sfg.io/teams/results

Obratiti pažnju na skalabilnost - značajno povećanje količine podataka (milion puta), dodavanje novih tipova podataka i slično.
