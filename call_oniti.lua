require("Econometre")

-- on lit stdin
s = io.read("*a")

-- équivalent d'un "eval" PHP
loadstring(s)()

MOTEUR_ECO(ECO_IN)

function serialiseJson(value,key,separator)
	return '"'..key..'":"'..value..'"'..separator
end

function endcomma(k)
	if k == 1 then
		return ','
	else
		return ''
	end
end

-- On construit un JSON a la main
json = '['

for k=1,2 do
	json = json..'{'..
			serialiseJson(ECO_OUT[k].Modele,'modele',',')..
			serialiseJson(ECO_OUT[k].ID,'id',',')..
			serialiseJson(ECO_OUT[k].Gain,'gain',',')..
			serialiseJson(ECO_OUT[k].ROI,'rOI',',')..
			serialiseJson(ECO_OUT[k].ROI_CITE,'rOI_CITE',',')..
			serialiseJson(ECO_OUT[k].Gain_CO2,'gainCO2',',')..
			serialiseJson(ECO_OUT[k].Reduction_CO2,'reductionCO2',',')..
			serialiseJson(ECO_OUT[k].BESOIN,'besoin',',')..
			serialiseJson(ECO_OUT[k].COP,'cOP','')
		..'}'..endcomma(k)
end
json = json..']'

print(json)