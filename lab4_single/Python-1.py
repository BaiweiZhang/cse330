import sys, os, re
import operator
 
if len(sys.argv) < 2:
 sys.exit("Usage: %s filename" % sys.argv[0])
 
filename = sys.argv[1]


class Player:

 def __init__(self, name, bat, hit):
  self.name = name
  self.bat=bat
  self.hit=hit

 def updateBats(self, bat):
  self.bat += bat
 def getName(self):
  return self.name
 def getBats(self):
  return self.bat

 def updateHits(self, hit):
  self.hit += hit

 def getHits(self):
  return self.hit

 def __eq__(self, other):
  return self.getName()==other.getName()
  
 def getBattingAvg(self):
  if int(self.hit != 0):
   battingAv = float(self.getHits())/ float(self.getBats())
   
   return float(round(battingAv, 3))
  else:
   return 0



if not os.path.exists(filename):
 sys.exit("Error: File '%s' not found" % sys.argv[1])
 
 
 
 
 
player_List=[]
f = open(filename, 'r')
lines = [line.rstrip('\n') for line in f]
# firstname lastname batted x times with z hits and n runs
player_re = re.compile(r'(\w*\s\w*) batted (\d*) times with (\d*) hits and (\d*) runs')



for a in lines:
 result=player_re.match(a)
 if result is not None:
  player_name = result.group(1)
  player_batTime = int(result.group(2))
  player_hitTime = int(result.group(3))
  
  newPlayer = Player(player_name, player_batTime, player_hitTime)
  
  if newPlayer not in player_List:
	
   player_List.append(newPlayer)
  else:
   for x in player_List:
    if x == newPlayer:
     x.updateBats(player_batTime)
     x.updateHits(player_hitTime)
 
 

def batAv(Player):
 return Player.getBattingAvg()


sortedList = sorted(player_List, key = batAv, reverse = True)
			
for each in sortedList:
 print each.name,": ",'{0:.3f}'.format(each.getBattingAvg())
   

	
	
	
	

					
					
					
		