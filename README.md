# Web-app for economics

# Web Economics Game

## Project Overview

This project is a web-based economics game where players manage a state and compete against another state to achieve a higher index. The goal is to outperform the opposing state by strategically adjusting various economic parameters over the course of 10 turns.

## Gameplay

In this game, players can adjust the following economic indicators:

- Percent rate
- Reservation rate
- Transferts for households
- Taxes for households
- Transferts for firms
- Taxes for firms
- Fixed bonds
- Variable bonds
- Indexed bonds
- Amortisation Bonds

### Key Metrics

Based on these adjustments, the game calculates the following key metrics for each state:

- GDP per capita
- State budget status
- Rate of inflation
- Unemployment rate

### Victory Conditions

To win the game, your state's index must be higher than that of the opposing state. The index is calculated using the following formula:

$ Country \> index = 0.2 \cdot GDP_{per \> capita}+ 0.4 \cdot Budget + 0.3 \cdot Inflation \> rate + 0.3 * Unemployment \> rate$ \
where 
$$Budget = \begin{cases} 
0, \> if \> budget \> status \> is \> deficit\\
1, \> if \> budget \> status \> is \> surplus\\
2, \> if \> budget \> status \> is \> balanced\\
\end{cases}$$